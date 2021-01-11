<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Subscriber;
use App\Jobs\Subscribe;
use App\Admin\Product;
use App\Admin\Slider;
use App\Admin\MailContent;
use App\Admin\JobApplication;
use App\Admin\AboutUs;
use App\Admin\Media;
use App\Admin\MediaImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{

    public function addSubscriber(Request $request)
    {
        $errorMessage = "";
        $success = true;
        $subscriber = [];
        try {
            $request->validate([
                "email" => "email"
            ]);

            $data = $request->all();
            $subscriber = Subscriber::create($data);
            if ($subscriber) {
                $subscribers = Subscriber::where('status', 0)->pluck('email');
                $mailData = MailContent::where('type', 'subsciber')->first();
                $mail = array('subject' => $mailData->subject, 'message' => $mailData->message);
                Subscribe::dispatch($subscribers, $mail);
                Subscriber::where('status', '=', 0)
                    ->update(['status' => 1]);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['subscriber' => $subscriber, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function addJobApplicaion(Request $request)
    {
        $errorMessage = "";
        $success = true;
        $application = [];
        try {
            $request->validate([
                "name" => "required|max:191",
                "email" => "email",
                "job_title" => "max:191",
                "company" => "max:191",
                "phone" => "required|max:191",
                "subject" => "required|max:191",
                "message" => "required",
            ]);

            $data = $request->all();
            $application = JobApplication::create($data);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['application' => $application, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAllProducts()
    {
        $errorMessage = "";
        $success = true;
        $productsResponse = [];
        try {
            $products = Product::with('category')->get();
            foreach ($products as $product) {
                $productsResponse[$product->category->name]['products'][] = $product;
                $productsResponse[$product->category->name]['category'] = $product->category;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['category' => $productsResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getSliders()
    {
        $errorMessage = "";
        $success = true;
        $slidersResponse = [];
        try {
            $sliders = Slider::all();
            foreach ($sliders as $key => $slider) {
                $slidersResponse[$key] = $slider;
                $slidersResponse[$key]['image'] = asset("/uploads/" . $slider->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['sliders' => $slidersResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAboutUsData()
    {
        $errorMessage = "";
        $success = true;
        $aboutResponse = [];
        try {
            $aboutUs = AboutUs::all();
            foreach ($aboutUs as $key => $about) {
                $aboutResponse[$key] = $about;
                $aboutResponse[$key]['image'] = asset("/uploads/" . $about->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['about' => $aboutResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getMedia()
    {
        $errorMessage = "";
        $success = true;
        $mediaResponse = [];
        try {
            $medias = Media::all();
            foreach ($medias as $key => $media) {
                $mediaResponse[$key] = $media;
                $images = MediaImage::where('media_id',$media->id)->get();
                $mediaResponse[$key]['image'] = $images;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['media' => $mediaResponse, 'success' => $success, 'errorMessage' => $errorMessage]);

    }

}
