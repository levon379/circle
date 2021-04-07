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


use App\Admin\Slider;
use App\Admin\Category;

use App\Admin\AboutUs;
use App\Admin\Media;
use App\Admin\MediaImage;
use App\Admin\Overview;
use App\Admin\History;
use App\Admin\Integrated;
use App\Admin\MissionVision;
use App\Admin\HealthSafety;
use App\Admin\AroundWorld;
use App\Admin\People;
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
            foreach ($data as $key => $item) {
                $Response[$key] = $item;
                $Response[$key]['image'] = asset("/uploads/" . $item->path);
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
    public function getShop()
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
