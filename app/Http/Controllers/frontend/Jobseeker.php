<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facade\JobCallMe;
use DB;
use PDF;
use Zipper;
use File;
use Redis;

class Jobseeker extends Controller{
	public function post(Request $request){
		$userid = $request->session()->get('jcmUser')->userId;
		$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
		
		foreach($task as &$rec){
			$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
			$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
			$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
			$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
			foreach($rec->comment as &$recs){
				$recs->reply=DB::table('post_comments_reply')->select('post_comments_reply.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments_reply.user_Id')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments_reply.user_Id')->where('parent_id','=',$recs->cmt_id)->get()->toArray();
			}
		}
		
        return request()->json('200',$task);
	}

	public function addpost(Request $request){
		//dd($request->all());
		$userid = $request->session()->get('jcmUser')->userId;
		if($request->get('image'))
       {
          $image = $request->get('image');
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          \Image::make($request->get('image'))->save(public_path('images/').$name);
		}
		$input['post_text']=$request->artical;
		$input['image']=$name;
		$input['user_id']=$userid;
		$input['post_type']='post';
		$input['status']='Active';
		$post=DB::table('posts')->insert($input);
		//return $post;
		if($post){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
				
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
		}


	}

	public function addcmt(Request $request){
		//dd($request->all());
		$userid = $request->session()->get('jcmUser')->userId;
		if($request->cmt_id){
			$input['comt_text']=$request->comt_text;
			$post=DB::table('post_comments')->where('cmt_id','=',$request->cmt_id)->update($input);
			if($post){
				$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
				
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
					$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
			}
		}
		else{
		
		$input['comt_text']=$request->comt_text;
		$input['pst_id']=$request->pst_id;
		$input['userId']=$userid;
		$post=DB::table('post_comments')->insert($input);
		//return $post;
		if($post){
				$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
				
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
					$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
			}
		}
	}


	public function cmtperpost(Request $request){
		//dd($request->all());
		$post_id=$request->pst_id;
		$userid = $request->session()->get('jcmUser')->userId;
		if($request->cmt_id){
			$input['comt_text']=$request->comt_text;
			$post=DB::table('post_comments')->where('cmt_id','=',$request->cmt_id)->update($input);
			if($post){
				$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->where('post_id','=',$post_id)->get();
				
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
					$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
			}
		}
		else{
		
		$input['comt_text']=$request->comt_text;
		$input['pst_id']=$request->pst_id;
		$input['userId']=$userid;
		$post=DB::table('post_comments')->insert($input);
		//return $post;
		if($post){
				$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->where('post_id','=',$post_id)->get();
				
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
					$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
			}
		}
	}

	public function replycmt(Request $request){
		//dd($request->all());
		$userid = $request->session()->get('jcmUser')->userId;
		$input['reply_text']=$request->reply_text;
		$input['parent_id']=$request->parent_id;
		$input['post_Id']=$request->post_Id;
		$input['user_Id']=$userid;
		$post=DB::table('post_comments_reply')->insert($input);
		//return $post;
		if($post){
				$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
				
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				    $rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
					foreach($rec->comment as &$recs){
						$recs->reply=DB::table('post_comments_reply')->select('post_comments_reply.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments_reply.user_Id')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments_reply.user_Id')->where('parent_id','=',$recs->cmt_id)->get()->toArray();
					}
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
			}
	}
	public function likepost(Request $request){
		//dd($request->all());
		$userid = $request->session()->get('jcmUser')->userId;
		
		$input['post_ID']=$request->post_ID;
		$input['user_Id']=$userid;
		$post=DB::table('post_like')->insert($input);
		if($post){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->limit(1)->get();
			$ret=array();
			foreach($task as &$rec){
				$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
			}
			
			$redis= Redis::connection();
			$redis->publish('message',json_encode($task));
			return request()->json('200',$task);
		}

	}

	public function dislike(Request $request,$id){
		$userid = $request->session()->get('jcmUser')->userId;
		$id=$request->id;
		$del=DB::table('post_like')->where('post_ID','=',$id)->where('user_ID','=',$userid)->delete();
		
		if($del){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->limit(1)->get();
				
				foreach($task as &$rec){
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
					$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
				}
		
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
		}

	}

	public function perlikepost(Request $request){
		//dd($request->all());
		$userid = $request->session()->get('jcmUser')->userId;
		
		$input['post_ID']=$request->post_ID;
		$input['user_Id']=$userid;
		$post=DB::table('post_like')->insert($input);
		if($post){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->where('post_ID','=',$request->post_ID)->get();
			foreach($task as &$rec){
				$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
			}
			$redis= Redis::connection();
			$redis->publish('message',json_encode($task));
			return request()->json('200',$task);
		}

	}

	public function perdislike(Request $request,$id){
		$userid = $request->session()->get('jcmUser')->userId;
		$id=$request->id;
		$del=DB::table('post_like')->where('post_ID','=',$id)->where('user_ID','=',$userid)->delete();
		
		if($del){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->where('post_ID','=',$id)->get();
			foreach($task as &$rec){
				$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				$rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
			}
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
		}

	}

	public function deletedata(Request $request,$id){

		$id=$request->id;
		$del=DB::table('posts')->where('post_id',$id)->delete();
		DB::table('post_comments_reply')->where('parent_id',$id)->delete();
		if($del){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
			
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
		}

	}

	public function deletecmt(Request $request,$id){

		$id=$request->id;
		$del=DB::table('post_comments')->where('cmt_id',$id)->delete();
		if($del){
			$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->orderBy('posts.created_at','desc')->get();
				$ret=array();
				foreach($task as &$rec){
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				    $rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
					foreach($rec->comment as &$recs){
						$recs->reply=DB::table('post_comments_reply')->select('post_comments_reply.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments_reply.user_Id')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments_reply.user_Id')->where('parent_id','=',$recs->cmt_id)->get()->toArray();
					}
				}
				
				$redis= Redis::connection();
				$redis->publish('message',json_encode($task));
				return request()->json('200',$task);
		}

	}
	public function editcmt(Request $request,$id){
		$id=$request->id;
		$edit=DB::table('post_comments')->where('cmt_id',$id)->get();
		return request()->json('200',$edit);
	}
	public function news(Request $request){
		
		$news=DB::table('jcm_news')->get();
		return request()->json('200',$news);
	}

	public function pernews(Request $request,$id){
		
		$news=DB::table('jcm_news')->where('newsId','=',$id)->get();
		return request()->json('200',$news);
	}
	
	public function perpost(Request $request,$id){
		$userid = $request->session()->get('jcmUser')->userId;
		$task=DB::table('posts')->select('posts.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','posts.user_id')->join('jcm_users_meta','jcm_users_meta.userId','=','posts.user_id')->where('post_id','=',$id)->get();
		foreach($task as &$rec){
			        $rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->comment=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->get()->toArray();
					$rec->count=DB::table('post_comments')->select('post_comments.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments.userId')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments.userId')->where('pst_id','=',$rec->post_id)->count();
					$rec->isFavorited=DB::table('post_like')->where('post_ID','=',$rec->post_id)->where('user_ID','=',$userid)->count();
				    $rec->likecount=DB::table('post_like')->where('post_ID','=',$rec->post_id)->count();
					foreach($rec->comment as &$recs){
						$recs->reply=DB::table('post_comments_reply')->select('post_comments_reply.*','jcm_users.firstName','jcm_users.lastName','jcm_users.profilePhoto')->join('jcm_users','jcm_users.userId','=','post_comments_reply.user_Id')->join('jcm_users_meta','jcm_users_meta.userId','=','post_comments_reply.user_Id')->where('parent_id','=',$recs->cmt_id)->get()->toArray();
					}
				}
		
		return request()->json('200',$task);
	}

	public function homefeed(Request $request){
		    	$app = $request->session()->get('jcmUser');
				$user = DB::table('jcm_users')->where('userId',$app->userId)->first();
				$lear_record = DB::table('jcm_upskills')->orderBy('skillId','desc')->limit(6)->get();
				$company = DB::table('jcm_companies');
		    	$company->orderBy('companyId','desc');
				$company->where('category','!=','');
		    	$company->limit(4);
		    	$companies = $company->inRandomOrder()->get();
    	    	$followArr = array();
    			if($request->session()->has('jcmUser')){
    				$meta = JobCallMe::getUserMeta($request->session()->get('jcmUser')->userId);
    				$savedJobArr = @explode(',', $meta->saved);
    				$followArr = @explode(',', $meta->follow);
    			}
				return view('frontend.jobseeker.userHome',compact('user','lear_record','companies','followArr'));
	}

	
	public function getState(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$countryId = $request->segment(3);
		$cities = JobCallMe::getJobStates($countryId);
		return view('frontend.jobseeker.stateCatView',compact('cities'));
		/*echo @json_encode($cities);*/
	}

	public function getCity(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$stateId = $request->segment(3);
		/*$cities = JobCallMe::getJobCities($stateId);*/
		$cities2 = JobCallMe::getJobCities($stateId);
		return view('frontend.jobseeker.cityCatView',compact('cities2'));
		/*echo @json_encode($cities2);*/
	}

	

	public function savePersonalInfo(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'firstName' => 'required|min:1|max:50',
				'lastName' => 'required|min:1|max:50',
				'fatherName' => 'required|min:1|max:50',
				'cnicNumber' => 'required|max:20',
				'gender' => 'required',
				'maritalStatus' => 'required',
				'dateOfBirth' => 'required|date',
				'email' => 'required|email',
				'phoneNumber' => 'required|max:20',
				'address' => 'required|max:255',
				'country' => 'required',
				'city' => 'required',
				'state' => 'required',
				'education' => 'required',
				'industry' => 'required',
				'experiance' => 'required',
				//'currentSalary' => 'required|numeric',
				//'expectedSalary' => 'required|numeric',
				'currency' => 'required',
				'expertise' => 'required',
				'about' => 'required',
				'facebook' => 'nullable|url',
				'linkedin' => 'nullable|url',
				'twitter' => 'nullable|url',
				'website' => 'nullable|url',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','=',$app->userId)->where('email','=',$email)->first();
		if(count($isUser) > 1){
			exit('User with give email already exist');
		}

		$userQry = array('firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phoneNumber' => $phoneNumber, 'country' => $country, 'state' => $state, 'city' => $city, 'about' => $about);
		DB::table('jcm_users')->where('userId',$app->userId)->update($userQry);

		$metaQry = array('fatherName' => $fatherName, 'dateOfBirth' => $dateOfBirth, 'gender' => $gender, 'maritalStatus' => $maritalStatus, 'experiance' => $experiance, 'education' => $education, 'industry' => $industry, 'subCategoryId' => $subCategoryId, 'subCategoryId2' => $subCategoryId2, 'shift' => $shift, 'currency' => $currency, 'currentSalary' => $currentSalary, 'expectedSalary' => $expectedSalary, 'expectedSalary2' => $expectedSalary2,  'cnicNumber' => $cnicNumber, 'address' => $address, 'address2' => $address2, 'expertise' => $expertise, 'facebook' => '', 'linkedin' => '', 'twitter' => '', 'website' => '');
		if($facebook != '') $metaQry['facebook'] = $facebook;
		if($linkedin != '') $metaQry['linkedin'] = $linkedin;
		if($twitter != '') $metaQry['twitter'] = $twitter;
		if($website != '') $metaQry['website'] = $website;

		if($metaId != '' && $metaId != '0' && $metaId != NULL){
			DB::table('jcm_users_meta')->where('metaId','=',$metaId)->update($metaQry);
		}else{
			$metaQry['follow'] = '';
			$metaQry['saved'] = '';
			$metaQry['userId'] = $app->userId;
			$metaQry['createdTime'] = date('Y-m-d H:i:s');
			DB::table('jcm_users_meta')->insert($metaQry);
		}
		exit('1');
	}


	public function savePassword(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'oldPassword' => 'required|max:16',
				'password' => 'required|min:6|max:16|confirmed',
				'password_confirmation' => 'required|min:6|max:16',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','=',$app->userId)->where('password','=',md5($oldPassword))->first();
		if(count($isUser) == 0){
			exit('Exisitng password is not valid');
		}

		$input = array('password' => md5($password));
		DB::table('jcm_users')->where('userId','=',$app->userId)->update($input);
		exit('1');
	}

	public function saveProfile(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		$this->validate($request, [
				'firstName' => 'required|max:50',
				'lastName' => 'required|max:50',
				'email' => 'required|max:255|email',
				'phoneNumber' => 'required',
				'city' => 'required',
				'state' => 'required',
				'address' => 'required',
			]);

		extract(array_map('trim', $request->all()));

		$isUser = DB::table('jcm_users')->where('userId','<>',$app->userId)->where('email','=',$email)->first();
		if(count($isUser) > 0){
			exit('Email alrady exist');
		}

		$input = array('firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phoneNumber' => $phoneNumber, 'city' => $city, 'state' => $state, 'country' => $country);
		DB::table('jcm_users')->where('userId','=',$app->userId)->update($input);

		if(count(JobCallMe::getUserMeta($app->userId)) > 0){
			DB::table('jcm_users_meta')->where('userId','=',$app->userId)->update(array('address' => $address));
		}else{
			$input = array('userId' => $app->userId, 'address' => $address, 'createdTime' => date('Y-m-d H:i:s'));
			DB::table('jcm_users_meta')->insert($input);
		}
		exit('1');
	}

	public function profilePicture(Request $request){
		if(!$request->ajax()){
			exit('Directory access is forbidden');
		}
		$app = $request->session()->get('jcmUser');
		if($request->file('profilePicture') != ''){

		$fName = $_FILES['profilePicture']['name'];
		$ext = @end(@explode('.', $fName));
		if(!in_array(strtolower($ext), array('png','jpg','jpeg'))){
			exit('1');
		}

		$user = DB::table('jcm_users')->where('userId',$app->userId)->first();
		
		$image = $request->file('profilePicture');
		$profilePicture = 'profile-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();       
        $destinationPath = public_path('/profile-photos');
        $image->move($destinationPath, $profilePicture);

        }
        if($request->input('chat') == 'yes'){
        	$pImage = '';
        	$data = array();
        	if($user->chatImage != ''){
        		$pImage = $user->chatImage;
        	}
        	if($pImage != ''){
        	    @unlink(public_path('/profile-photos/'.$pImage));
        	}
        	if($request->input('nickName') != ''){
        		$data['nickName'] = $request->input('nickName');
        	}
        	if($request->file('profilePicture') != ''){
        		$data['chatImage'] = $profilePicture;
        	}
        	DB::table('jcm_users')->where('userId',$app->userId)->update($data);
        	if($request->file('profilePicture') != ''){
        		echo url('profile-photos/'.$profilePicture);
        	}else{
        		echo 'noUrl';
        	}
        	
        }else{
        	$pImage = '';
        	if($user->profilePhoto != ''){
        		$pImage = $user->profilePhoto;
        	}
        	if($pImage != ''){
        	    @unlink(public_path('/profile-photos/'.$pImage));
        	}
        	DB::table('jcm_users')->where('userId',$app->userId)->update(array('profilePhoto' => $profilePicture));
        	echo url('profile-photos/'.$profilePicture);
        }
        
	}

}
