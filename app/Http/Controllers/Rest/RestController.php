<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Subscriber;
use App\Admin\Category;
use App\Jobs\Subscribe;
use App\Admin\Product;
use App\Admin\Slider;
use App\Admin\MailContent;
use App\Admin\JobApplication;
use App\Admin\AboutUs;
use App\Admin\Media;
use App\Admin\MediaImage;
use App\Admin\WhyTahweel;
use App\Admin\Overview;
use App\Admin\Integrated;
use App\Admin\MissionVision;
use App\Admin\HealthSafety;
use App\Admin\AroundWorld;
use App\Admin\People;
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
    
    public function getCategories() {
        $errorMessage = "";
        $success = true;
        $categoryResponse = [];
        try {
            $categories = Category::all();
            foreach ($categories as $key=>$category) {
                $categoryResponse[$key] = $category;
                $categoryResponse[$key]['pdf'] = asset("/uploads/" . $category->pdf_path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['category' => $categoryResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAllProductsByCategory($categoryId)
    {
        $errorMessage = "";
        $success = true;
        $productsResponse = [];
        try {
            $products = Product::where('category_id',$categoryId)->with('category','details')->get();
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

    public function getWhyTahweel()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = WhyTahweel::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
                $whyTahweelResp[$key]['image'] = asset("/uploads/" . $tahweel->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['whyTahweel' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);

    }

    public function getOverview()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = Overview::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
                $whyTahweelResp[$key]['image'] = asset("/uploads/" . $tahweel->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['overview' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);

    }

    public function getMissionVission()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = Integrated::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['missionVision' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getTwahweelIntegrated()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = MissionVision::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['integrated' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getHealTyAndSafety()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = HealthSafety::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
                $whyTahweelResp[$key]['image'] = asset("/uploads/" . $tahweel->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['healthSafety' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAroundWorld()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = AroundWorld::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['aroundWorld' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getTahweelPeople()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = People::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
                $whyTahweelResp[$key]['image'] = asset("/uploads/" . $tahweel->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['people' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

}
