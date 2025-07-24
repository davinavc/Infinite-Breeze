<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\BlogImage;
use Carbon\Carbon;


class BlogController extends Controller
{
    public function welcome()
    {
        $news = Blog::where('category', 'News')
                ->where('status', 'News') // tampilkan hanya yang sudah publish
                ->latest()
                ->take(3)
                ->get();

        $highlight = Blog::where('category', 'Event')
                ->where('status', 'Event') // tampilkan hanya yang sudah publish
                ->latest()
                ->take(3)
                ->get();

        $now = Carbon::now();
        $events = Event::orderBy('start_date')->get();
        
        $upcomingEvents  = Event::whereDate('start_date', '>', $now)->orderBy('start_date')
                ->take(3)
                ->get();
        
        $blogs = Blog::latest()->take(3)->get(); // Ambil 3 blog terbaru
        return view('welcome', compact('blogs', 'events', 'upcomingEvents', 'highlight', 'news'));
    }

    public function index(){
        $blog = Blog::all();
        return view('admin.blog', compact('blog'));
    }

    public function event(){
        $blogs = Blog::where('category', 'Event')
                ->where('status', 'Published') // tampilkan hanya yang sudah publish
                ->latest()
                ->get();
        return view('admin.blog.event', compact('blogs'));
    }

    public function tips(){
        $blogs = Blog::where('category', 'Tips')
                ->where('status', 'Published') // tampilkan hanya yang sudah publish
                ->latest()
                ->get();
        return view('admin.blog.tips', compact('blogs'));
    }

    public function upcoming(){
        $now = Carbon::now();
        $events = Event::whereDate('start_date', '>', $now)->orderBy('start_date')->get();
        return view('admin.blog.upcoming', compact('events'));
    }

    public function ongoing(){
        $now = Carbon::now();
        $events = Event::whereDate('start_date', '<=', $now)
                   ->whereDate('finish_date', '>=', $now)
                   ->orderBy('start_date')
                   ->get();
        return view('admin.blog.ongoing', compact('events'));
    }

    public function detailnews($id){
        $blog = Blog::with('images')->where('category', 'News')->findOrFail($id);
        $headerImage = $blog->images->where('image_type', 'header')->first();
        $contentImages = $blog->images->where('image_type', 'content');
        return view('admin.blog.detail-news', compact('blog', 'headerImage', 'contentImages'));
    }

    public function detailevent($id){
        $blog = Blog::with('images')->where('category', 'Event')->findOrFail($id);
        $headerImage = $blog->images->where('image_type', 'header')->first();
        $contentImages = $blog->images->where('image_type', 'content');
        
        return view('admin.blog.detail-event', compact('blog', 'headerImage', 'contentImages'));
    }

    public function detailupcoming($id){
        $event = Event::findOrFail($id);

        // Ambil transaksi yang statusnya sukses untuk event ini
        $tenants = Transaksi::where('event_id', $id)
                    ->where('status', 'Successful')
                    ->with('tenant') // untuk ambil data tenant
                    ->get()
                    ->pluck('tenant') // ambil objek tenant-nya
                    ->unique('id');   // hindari duplikat

        return view('admin.blog.detail-upcoming', compact('event', 'tenants'));
    }

    public function detailongoing(){
        $now = Carbon::now();
        $event = Event::whereDate('start_date', '<=', $now)
                ->whereDate('finish_date', '>=', $now)
                ->orderBy('start_date')
                ->first(); // ✅ ubah dari get() ke first()

        // Ambil transaksi yang statusnya sukses untuk event ini
        $tenants = [];

        if ($event) {
            $tenants = Transaksi::where('event_id', $event->id)
                        ->where('status', 'Successful')
                        ->with('tenant')
                        ->get()
                        ->pluck('tenant')
                        ->unique('id');
        }
        return view('admin.blog.detail-ongoing', compact('event', 'tenants'));
    }

    public function news(){
        $blogs = Blog::where('category', 'News')
                ->where('status', 'Published') // tampilkan hanya yang sudah publish
                ->latest()
                ->get();
        return view('admin.blog.news', compact('blogs'));
    }

    public function aboutus(){
        $blog = Blog::all();
        return view('admin.blog.aboutus', compact('blog'));
    }

    public function create()
    {
        $now = Carbon::now();
        $events = Event::whereDate('finish_date', '>=', $now)->get();
        return view('admin.addBlog', compact('events'));
    }
    
    public function store(Request $request)
    {
        //  dd($request->all());
        // Validasi dulu
        $request->validate([
            'judul_blog' => 'required|string|max:255',
            'deskripsi_blog' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'event_id' => 'nullable|exists:event,id',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tentukan status blog (draft atau publish)
        $status = $request->input('action') === 'Published' ? 'Published' : 'Draft';

        // Simpan data blog utama
        $blog = Blog::create([
            'title' => $request->judul_blog,
            'description' => $request->deskripsi_blog,
            'content' => $request->content,
            'category' => $request->category,
            'event_id' => $request->category === 'Event' ? $request->event_id : null,
            'status' => $status,
        ]);

        // Upload dan simpan gambar header 
        if ($request->hasFile('header_image')) {
            $headerPath = $request->file('header_image')->store('blog/headers', 'public');
            BlogImage::create([
                'blog_id' => $blog->id,
                'image_path' => $headerPath,
                'image_type' => 'header',
            ]);
        }

        // Upload dan simpan gambar konten
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                $contentPath = $image->store('blog/contents', 'public');
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'image_path' => $contentPath,
                    'image_type' => 'content',
                ]);
            }
        }

        // Jika blog terkait event dan ingin auto-ambil poster event
        if ($request->category === 'Event' && $request->event_id) {
            $event = Event::find($request->event_id);
            if ($event && $event->poster) {
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'image_path' => $event->poster,
                    'image_type' => 'header', // misal dijadikan header juga
                ]);
            }
        }
        return redirect()->route('dashboard.admin.blog')->with('success', 'Blog berhasil dibuat!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $headerImage = $blog->images->where('image_type', 'header')->first();
        $contentImages = $blog->images->where('image_type', 'content');
        $now = Carbon::now();
        $events = Event::all();
        return view('admin.editBlog', compact('blog', 'events', 'headerImage', 'contentImages'));
    }

    public function update(Request $request)
    {
        
        $request->validate([
            'judul_blog' => 'required|string|max:255',
            'deskripsi_blog' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'event_id' => 'nullable|exists:event,id',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = Blog::findOrFail($request->id);

        $action = $request->input('action');
        if ($action === 'Published') {
            $status = 'Published';
        } elseif ($action === 'Archived') {
            $status = 'Archived';
        } else {
            $status = 'Draft';
        }
       
        $blog->update([
            'title' => $request->judul_blog,
            'description' => $request->deskripsi_blog,
            'content' => $request->content,
            'category' => $request->category,
            'event_id' => $request->category === 'Event' ? $request->event_id : null,
            'status' => $status,
        ]);

        // Jika centang hapus gambar header
        if ($request->has('delete_header')) {
            $oldHeader = $blog->blog_images()->where('image_type', 'header')->first();
            if ($oldHeader) {
                Storage::disk('public')->delete($oldHeader->image_path);
                $oldHeader->delete();
            }
        }

        // Jika unggah gambar header baru
        if ($request->hasFile('header_image')) {
            // Hapus lama jika ada
            $oldHeader = $blog->blog_images()->where('image_type', 'header')->first();
            if ($oldHeader) {
                Storage::disk('public')->delete($oldHeader->image_path);
                $oldHeader->delete();
            }

            $headerPath = $request->file('header_image')->store('blog/headers', 'public');
            BlogImage::create([
                'blog_id' => $blog->id,
                'image_path' => $headerPath,
                'image_type' => 'header',
            ]);
        }

        // Hapus gambar konten jika ada yang dipilih
        if ($request->has('delete_content_images')) {
            foreach ($request->delete_content_images as $imageId) {
                $contentImage = BlogImage::where('id', $imageId)
                                    ->where('blog_id', $blog->id)
                                    ->where('image_type', 'content')
                                    ->first();
                if ($contentImage) {
                    Storage::disk('public')->delete($contentImage->image_path);
                    $contentImage->delete();
                }
            }
        }

        // Upload gambar konten baru
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                $contentPath = $image->store('blog/contents', 'public');
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'image_path' => $contentPath,
                    'image_type' => 'content',
                ]);
            }
        }
        return redirect()->route('dashboard.admin.blog')->with('success', 'Blog berhasil diupdate!');
    }

    public function show($id, Request $request)
    {
        $blog = Blog::findOrFail($id);
        $headerImage = $blog->images->where('image_type', 'header')->first();
        return view('admin.detailBlog', compact('blog', 'headerImage'));
        
    }
}