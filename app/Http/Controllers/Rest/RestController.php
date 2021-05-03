<?php

namespace App\Http\Controllers\Rest;


use App\Admin\Blog;
use App\Admin\BlogImage;
use App\Admin\BlogScheme;
use App\Admin\OurTeam;
use App\Admin\OurTeamMain;
use App\Admin\OurWorks;
use App\Admin\OurWorksMain;
use App\Admin\Shop;
use App\Admin\ShopMain;
use App\Admin\WorkWithUsMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
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
                $Response['type' . $i] = $item;
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
                foreach ($item->our_services_list as $list_items) {
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
        return response()->json(['shop_by_category' => $Response, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    public function getAllShop()
    {
        $errorMessage = "";
        $success = true;
        $Response = [];
        try {
            $data = Shop::orderBy('ordering', 'asc')->get();
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
            $data = Vacancy::orderBy('ordering', 'asc')->get();
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

    public function addBlog(Request $request)
    {
        $errorMessage = "";
        $success = true;
        $blogResponse = [];
        try {
            DB::beginTransaction();
            $data = [];
            $storeData = $request->all();
            if (count($storeData)) {
                array_push($data, $storeData);
            }
            $blog = Blog::create(['title' => 'asdas', 'description' => 'asdasd']);
            foreach ($data as $blogScheme) {
                $blogData = ['cols' => $blogScheme['col'], 'title' => $blogScheme['header'],
                    'description' => $blogScheme['description'], 'blog_id' => $blog->id];
                $scheme = BlogScheme::create($blogData);
                $imageId = null;
                if (isset($blogScheme['image'])) {
                    //$request->validate(["image" => "image|max:5000"]);
                    //if($request->file('image')->isValid()) {
                    $blogSchemeImage = Storage::disk('public')->putFile('blog-scheme', new File($blogScheme['image']));
                    $blogSchemeImageData = ['image_path' => $blogSchemeImage, 'is_background' => 0];
                    $imageId = BlogImage::create($blogSchemeImageData);
                    //}
                } elseif (isset($blogScheme['background'])) {
                    //$request->validate(["background" => "image|max:5000"]);
                    //if($request->file('background')->isValid()) {
                    $blogSchemeBackground = Storage::disk('public')->putFile('blog-scheme', new File($blogScheme['background']));
                    $blogSchemeImageData = ['image_path' => $blogSchemeBackground, 'is_background' => 1];
                    $imageId = BlogImage::create($blogSchemeImageData);
                    //}
                }
                $scheme->image_id = $imageId->id;
                $scheme->save();


                if (!empty($blogScheme['sub'])) {
                    $this->saveBlogSub($blogScheme['sub'], $scheme->id);
                }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            $success = false;
        }
        DB::commit();
        return response()->json(['blog' => $blogResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    private function saveBlogSub($subBlogData, $parentId)
    {
        foreach($subBlogData as $sub) {
            $subBlogStoreData = ['cols'=>$sub['col'],'title'=>$sub['header'],
                'description'=>$sub['description'],'parent_id'=>$parentId];
            $subBlogScheme = BlogScheme::create($subBlogStoreData);
            $imageId = null;
            if (isset($sub['image'])) {
                //$request->validate(["image" => "image|max:5000"]);
                //if($request->file('image')->isValid()) {
                $blogSchemeImage = Storage::disk('public')->putFile('blog-scheme', new File($sub['image']));
                $blogSchemeImageData = ['image_path'=>$blogSchemeImage,'is_background'=>0];
                $imageId = BlogImage::create($blogSchemeImageData);
                //}
            } elseif(isset($sub['background'])) {
                //$request->validate(["background" => "image|max:5000"]);
                //if($request->file('background')->isValid()) {
                $blogSchemeBackground = Storage::disk('public')->putFile('blog-scheme', new File($sub['background']));
                $blogSchemeImageData = ['image_path'=>$blogSchemeBackground,'is_background'=>1];
                $imageId = BlogImage::create($blogSchemeImageData);
                //}
            }
            $subBlogScheme->image_id = $imageId;
            $subBlogScheme->save();

            if(!empty($sub['sub'])) {
                $this->saveBlogSub($sub['sub'],$subBlogScheme->id);
            }
        }
    }

    public function getBlog($id)
    {
        $errorMessage = "";
        $success = true;
        $blogResponse = [];
        $subResp = [];
        try {
            $blog = Blog::with('blogScheme')->where('id', $id)->first();
            $blogResponse = ['id' => $blog->id, 'name' => $blog->title];
            if ($blog->blogScheme->count()) {
                $blogSchemes = $blog->blogScheme;
                foreach ($blogSchemes as $key => $blogScheme) {
                    $blogResponse['blogScheme'][$key] = [
                        'col' => $blogScheme->cols,
                        'header' => $blogScheme->title,
                        'description' => $blogScheme->description
                    ];
                    //echo "<pre>";var_dump($blogScheme->blogImage);die;
                    if ($blogScheme->blogImage && $blogScheme->blogImage->count()) {
                        $blogResponse['blogScheme'][$key]['image'] = $blogScheme->blogImage->image_path;
                    }
                    if ($blogScheme->blogBackground && $blogScheme->blogBackground->count()) {
                        $blogResponse['blogScheme'][$key]['background'] = $blogScheme->blogBackground->image_path;
                    }

                    if ($blogScheme->subs && $blogScheme->subs->count()) {
                        $blogResponse['blogScheme'][$key]['subs'] = $this->getSubs($blogScheme->subs);
                    }
                }
            }
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['blog' => $blogResponse, 'success' => $success, 'errorMessage' => $errorMessage]);
    }

    private function getSubs($subs , $arr = array())
    {
        if (!empty($subs)) {
            foreach ($subs as $key=>$ch) {
                $arr[$key]['col'] = $ch->cols;
                $arr[$key]['header'] = $ch->header;
                $arr[$key]['description'] = $ch->description;
                if($ch->blogImage &&  $ch->blogImage->count()) {
                    $arr[$key]['image'] = $ch->blogImage->image_path;
                }
                if($ch->blogBackground && $ch->blogBackground->count()) {
                    $arr[$key]['background'] = $ch->blogBackground->image_path;
                }
                if($ch->subs) {
                    $arr[$key]['subs'] = $this->getSubs($ch->subs, $arr);
                }
            }
        }

        return $arr;
    }

}
