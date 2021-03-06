<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;


use App\Models\Page;
use App\Models\Post;
use Auth;
use App\Utilities\Overrider;
use App\Mail\ContactEmail;

class WebsiteController extends Controller
{
	
	public function __construct()
    {	
		$theme = get_option('active_theme');
		if(file_exists(resource_path() . "/views/theme/$theme/functions.php")){
			include(resource_path() . "/views/theme/$theme/functions.php"); 
		}
    }

    public function index($slug=""){	
		if(get_option('disabled_website') == "yes"){
			return redirect('login');
		}
		$home_page = get_option('home_page');
		
		if($slug == "" && $home_page==""){
			return view(theme().'/index');
        }else{
			if($slug == ""){
				$page = Page::where("id",$home_page)->first();
			}else{
				$page = Page::where("slug",$slug)->first();
			}
			if($page){
				$template = theme().'.templates.template-'.$page->page_template;
				
				if($page->page_template == "default"){
					return view(theme().'.index',compact('page'));
				}			
				return view($template,compact('page'));

			}else{
				return view(theme().'.404');
			}	
		}		
    }
	
	public function single($slug=""){
		if($slug == ""){
			return view(theme().'.404');
		}else{
			$post = Post::where("slug",$slug)->first();
			if($post){
				return view(theme().'.single',compact('post'));
			}
			return view(theme().'.404');
		}
	}
	
	public function category_archive($cat_id=""){
		if($cat_id == ""){
			$category = new \stdClass;
			$category->id = 0;
			$category->category = _lang('Uncategorized');
			return view(theme().'.post-category',compact('category'));
		}else{
			$category = \App\Models\PostCategory::find($cat_id);
			if($category){
				return view(theme().'.post-category',compact('category'));
			}
			return view(theme().'.404');
		}
	}
	
	public function notice($id=""){
		$notice = \App\Models\Notice::join("user_notices","notices.id","user_notices.notice_id")
							  ->select('notices.*')
							  ->where("user_notices.user_type","Website")
							  ->where("notices.id",$id)
							  ->first();
		return view(theme().'.single-notice',compact('notice'));
	}
	
	public function event($id=""){
		$event = \App\Models\Event::where("id",$id)->first();
		return view(theme().'.single-event',compact('event'));
	}
	
	public function send_message(Request $request){
		Overrider::load("Settings");
		
		$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
			'subject' => 'required',
			'message' => 'required',
        ]);
		
		$name = $request->input("name");
		$email = $request->input("email");
		$subject = $request->input("subject");
		$message = $request->input("message");
		
		//Send Email
		$mail  = new \stdClass();
		$mail->name = $name;
		$mail->subject = $subject;
		$mail->message = $message;
		Mail::to(get_option('contact_email'))->send(new ContactEmail($mail));
		
		return redirect()->back()->with('success', _lang('Your Message Send Sucessfully.'));
		
	}
	
   
}
