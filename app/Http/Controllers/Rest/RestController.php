<?php

namespace App\Http\Controllers\Rest;


use App\Admin\OurTeam;
use App\Admin\OurTeamMain;
use App\Admin\OurWorks;
use App\Admin\OurWorksMain;
use App\Admin\Shop;
use App\Admin\ShopMain;
use App\Admin\WorkWithUsMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\HomePage;
use App\Admin\RequestQuoteMain;
use App\Admin\ContactMain;
use App\Admin\OurServices;
use App\Admin\OurServicesList;
use App\Admin\OurServicesListItem;
use Mail;

use App\Admin\Category;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{

    public function getHomePageIcons()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = HomePage::all();
            $i = 0;
            foreach ($data as $key => $item) {
                $i++;
                $Response['type'.$i] = $item;
                $Response[$item->type]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['home_page' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getRequestAQuoteImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = RequestQuoteMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['request_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getContactImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = ContactMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['contact_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getServices()
    {
        $errorMessage = "";
        $success = true;
        $response = [];
        try {
            $data = OurServices::with([
                'our_services_list',
            ])->get();
            //dd($data);

            foreach ($data as $item) {
                $item->load(['our_services_list' => function ($q) {
                    $q->orderBy('id', 'asc');
                }]);
                foreach($item->our_services_list as $list_items) {
                    $list_items->our_services_list_item;
                }
            }
            $response = $data;

        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['services' => $response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurTeamImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurTeamMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_team_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getWorksWithUsImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = WorkWithUsMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['work_with_us_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurTeam()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurTeam::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_team' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurWorksImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurWorksMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_works_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurWorks()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurWorks::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_works' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurWorksByCategory()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurWorks::all();
            foreach ($data as $key => $item) {
                $Response[$item->category][] = $item;
                //$Response['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_works' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getOurWorksOrder()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = OurWorks::whereNotNull('ordering')->limit(3)->get();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['our_works_order' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getShopImage()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = ShopMain::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['shop_image' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getShopByCategory()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {

            $data = Shop::all();
            foreach ($data as $key => $item) {
                $Response[$item->category_id][] = $item;
                //$Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['shop_by_category' => $Response,  'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getAllShop()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = Shop::orderBy('ordering','asc')->get();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['shop' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getVacancy()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = Vacancy::orderBy('ordering','asc')->get();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['vacancy' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getCareer()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = Career::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['career' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function getCategory()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = Category::all();
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['category' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function AddContact(Request $request)
    {
        //dd($request->all());
        $errorMessage = "";
        $success = true;
        $application = [];
        try {
                $request->validate([
                    'email' => 'required|email',
                    'subject' => 'required',
                    'content' => 'required',
                ]);

                $data = [
                    'subject' => 'contact us',
                    'email' => $request->email,
                    'content' => $request->message
                ];

                Mail::send('email-template', $data, function($message) use ($data) {
                    $message->to($data['email'])
                        ->subject($data['subject']);
                });

                return back()->with(['message' => 'Email successfully sent!']);

        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['application' => $application, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function AddWorkWithUs(Request $request)
    {
        dd($request->all());
        $errorMessage = "";
        $success = true;
        $application = [];
        try {
            $request->validate([
                "email" => "email",
                "message" => "required",
            ]);

            \Mail::send('',
                array(
                    'email' => $request->get('email'),
                    'message' => $request->get('message'),
                ), function($message) use ($request)
                {
                    $message->from($request->email);
                    $message->to('lev.hambardzumyan@gmail.com');
                });


        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['application' => $application, 'success' => $success, 'errorMessage' => $errorMessage]);
    }
    public function AddRequestAQuote(Request $request)
    {
        dd($request->all());
        $errorMessage = "";
        $success = true;
        $application = [];
        try {
            $request->validate([
                "email" => "email",
                "message" => "required",
            ]);

            \Mail::send('',
                array(
                    'email' => $request->get('email'),
                    'message' => $request->get('message'),
                ), function($message) use ($request)
                {
                    $message->from($request->email);
                    $message->to('lev.hambardzumyan@gmail.com');
                });


        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['application' => $application, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

}
