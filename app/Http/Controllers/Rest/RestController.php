<?php

namespace App\Http\Controllers\Rest;

use App\Admin\ContactUs;
use App\Admin\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Subscriber;
use App\Admin\Category;
use App\Jobs\Subscribe;
use App\Admin\RequestQuote;
use App\Admin\Slider;
use App\Admin\MailContent;
use App\Admin\JobApplication;
use App\Admin\AboutUs;
use App\Admin\Media;
use App\Admin\MediaImage;
use App\Admin\HomePage;
use App\Admin\Overview;
use App\Admin\History;
use App\Admin\Integrated;
use App\Admin\MissionVision;
use App\Admin\HealthSafety;
use App\Admin\AroundWorld;
use App\Admin\People;
use App\Admin\RequestQuoteMain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{
    public function verifySubscribtionEmail(Request $request)
    {
        $errorMessage = "";
        $success = true;
        try {
            $request->validate([
                "token" => "string"
            ]);

            $subscriber = Subscriber::where('email_verify_token', $request->token)->first();
            if (!$subscriber) {
                return response()->json(['success' => false, 'errorMessage' => 'Invalid token']);
            }
            if (!$subscriber->status) {
                $subscriber->status = 1;
                $subscriber->save();
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function verifyJobApplicationEmail(Request $request)
    {
        $errorMessage = "";
        $success = true;
        try {
            $request->validate([
                "token" => "string"
            ]);

            $jobApplication = JobApplication::where('email_verify_token', $request->token)->first();
            if (!$jobApplication) {
                return response()->json(['success' => false, 'errorMessage' => 'Invalid token']);
            }
            if (!$jobApplication->status) {
                $jobApplication->status = 1;
                $jobApplication->save();
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function addSubscriber(Request $request)
    {
        $errorMessage = "";
        $success = true;
        try {
            $request->validate([
                "email" => "email"
            ]);

            $subscriber = Subscriber::where('email', $request->email)->first();
            if ($subscriber) {
                if ($subscriber->status) {
                    return response()->json(['success' => false, 'errorMessage' => 'Already subscribed']);
                }
            }

            if (!$subscriber) {
                $token = uniqid() . random_int(1000, 9999);
                $data = [
                    'email' => $request->email,
                    'status' => 0,
                    'email_verify_token' => $token
                ];
                $subscriber = Subscriber::create($data);
            }

            $verificationLink = env('FRONT_URL') . 'subscriptionVerification/'. $subscriber->email_verify_token;
            $mailData = MailContent::where('type', 'subscriber')->first();
            $message = $mailData->message;
            $message = str_replace('{{email}}', $request->email, $message);
            $message = str_replace('{{verification_link}}', $verificationLink, $message);
            $mail = array('subject' => $mailData->subject, 'message' => $message);
            $subscribe = new Subscribe($request->email, $mail);
            $subscribe->dispatch($request->email, $mail);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['success' => $success, 'errorMessage' => $errorMessage]);
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

            $mailData = MailContent::where('type', 'application')->first();
            $message = $mailData->message;
            $message = str_replace('{{message}}', $request->message, $message);
            $message = str_replace('{{name}}', $request->name, $message);
            $message = str_replace('{{mobile}}', $request->phone, $message);
            $message = str_replace('{{subject}}', $request->subject, $message);
            $message = str_replace('{{start_date}}', $application->created_at->format('d M Y'), $message);

            $subject = $mailData->subject;
            $subject = str_replace('{{start_date}}', $application->created_at->format('d M Y'), $subject );
            $mail = array('subject' => $subject, 'message' => $message);
            $job_application = new Subscribe($request->email, $mail);
            $job_application->dispatch($request->email, $mail);

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
    public function getCategoryById($id) {
        $errorMessage = "";
        $success = true;
        $categoryResponse = [];
        try {
            $categories = Category::find($id);
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
            $category = Category::find($categoryId);
            $products = RequestQuote::where('category_id',$categoryId)->with([
                'product_list',
                //'product_list_items',
                'product_tabs_map',
//                'product_tabs_map' => function ($q) {
//                    $q->orderBy('tab_id', 'asc');
//                },
                'featured',
                //'category',
                'image',
                'specification'
            ])->orderBy('ordering','asc')->get();

            foreach ($products as $product) {
                foreach($product->product_tabs_map as $tabsMap) {
                    $tabsMap->get_tabs;
                }
                $product->load(['product_list' => function ($q) {
                    $q->orderBy('id', 'asc');
                }]);
                foreach($product->product_list as $list_items) {
                    $list_items->product_list_items;
                }
            }
            $productsResponse = $products;

        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['products' => $productsResponse, 'category' => $category, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAllProducts()
    {
        $errorMessage = "";
        $success = true;
        $productsResponse = [];
        try {
            $productsResponse = RequestQuote::with([
                'product_list',
                'product_tabs',
                'featured',
                'category',
                'image',
                'specification'
            ])->get();
//            foreach ($products as $product) {
//                $item = [];
//                $productsResponse[$product->category->name]['products'][] = $product;
//                $productsResponse[$product->category->name]['category'] = $product->category;
//            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['products' => $productsResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getSliders()
    {
        $errorMessage = "";
        $success = true;
        $slidersResponse = [];
        try {
            $sliders = Slider::orderBy('ordering','asc')->get();
            foreach ($sliders as $key => $slider) {
                $slidersResponse[$key] = $slider;
                $slidersResponse[$key]['category'] = $slider->category;
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
            $medias = Media::orderBy('ordering','asc')->get();
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
            $whyTahweel = HomePage::orderBy('ordering','asc')->get();
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
            $whyTahweel = MissionVision::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['missionVision' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getContactUs()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = ContactUs::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['contact_us' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getHistory()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = History::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['history' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getTwahweelIntegrated()
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
    public function getCareer()
    {
        $errorMessage = "";
        $success = true;
        $whyTahweelResp = [];
        try {
            $whyTahweel = RequestQuoteMain::all();
            foreach ($whyTahweel as $key => $tahweel) {
                $whyTahweelResp[$key] = $tahweel;
                $whyTahweelResp[$key]['image'] = asset("/uploads/" . $tahweel->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['career' => $whyTahweelResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getSocial()
    {
        $errorMessage = "";
        $success = true;
        $socialResp = [];
        try {
            $socTahweel = Social::orderBy('id','asc')->get();
            foreach ($socTahweel as $key => $social) {
                $socialResp[$key] = $social;
                $socialResp[$key]['image'] = asset("/uploads/" . $social->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['social' => $socialResp, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

}
