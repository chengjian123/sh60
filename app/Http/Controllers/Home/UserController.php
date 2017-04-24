<?php

namespace App\Http\Controllers\home;

use App\Album;
use App\Collection;
use App\Commit;
use App\Follow;
use App\Http\Requests\HomePushPing;
use App\Hui;
use App\Photo;
use App\Say;
use App\User;
use App\Zan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        //根据模型将所以的数据查询出来
        $id = Auth::user()->id;
        $hui =Hui::where('id','>','0')->orderBy('id','desc')->get();
        $zan = Zan::where('id','>','0')->get();
        $say =Say::where('id','>','0')->orderBy('id','desc')->get();
        $commit =Commit::where('id','>','0')->orderBy('id','desc')->get();
        $users_id = DB::select('select * from say where users_id = '.$id);
        $count_weibo =count($users_id);
        $follows = Follow::where('usersby_id','=',$id)->get();
        $count_fans = count($follows);
        while($say){
            return view('home.vip',compact('say','commit','count_weibo','hui','zan','count_fans'));
        }
    }

    public function doPushPing(HomePushPing $request)
    {
        $user = Auth::user()->id;
        $txt=$request->input('commit_content'); //获取提交的数据
        $txt= htmlspecialchars(stripslashes($txt));
        //   $txt=mysql_real_escape_string(strip_tags($txt),$link); //过滤HTML标签，并转义特殊字符
        if( mb_strlen($txt)<1 ||  mb_strlen($txt)>140){
            return  alert('输入合理的字数');
        }
        $users_id=$user;
        //插入数据到数据表中
        //   dd($request->all());
        $say_id = $request->input('say_id');
        $data=[
            'users_id'=>$users_id,
            'commit_users_id'=>$users_id,
            'say_id'=>$say_id,
        ];
        Commit::create(array_merge($request->all(),$data));

        return redirect('home/vip');
    }

    public function album()
    {

        $user = Auth::user()->id;
        $users = User::where('id','=',$user)->get();
        $album =Album::where('users_id','=',$user)->orderBy('id','desc')->get();
        while($album){
            return view('home/photo',compact('album','users'));
        }

    }


    public function album_other($id)
    {
        $users = User::where('id','=',$id)->get();
        $album =Album::where('users_id','=',$id)->orderBy('id','desc')->get();
        while($album){
            return view('home/photo',compact('album','users'));
        }

    }

    public function doalbum(Request $request)
    {
        $user = Auth::user()->id;
        $users_id = $user;

        $data=[
            'users_id'=>$users_id,
        ];
        Album::create(array_merge($request->all(),$data));

        return redirect('home/photo');
    }

    public function del_album($id)
    {
        //获取微博模型
        $album = Album::find($id);
        $album->delete();
        return redirect('home/photo');
    }


    public function upphoto(Request $request)
    {
        $user = Auth::user()->id;
        $users_id = $user;
        $picType = $request->photo_name->extension();

        $pic = 'home/images';
        $picName = md5(time()).'.'.$picType;
        $upUrl = $request->file('photo_name')->storeAs($pic, $picName);

       $data=[
            'users_id'=>$users_id,
           'photo_name'=>$upUrl,
        ];
        Photo::create(array_merge($request->all(),$data));

        return redirect('home/photo');
    }

    public function up_photo(Request $request , $id)
    {
        $user = Auth::user()->id;
        $users_id = $user;
        $picType = $request->photo_name->extension();

        $pic = 'home/images';
        $picName = md5(time()).'.'.$picType;
        $upUrl = $request->file('photo_name')->storeAs($pic, $picName);

        $data=[
            'users_id'=>$users_id,
            'photo_name'=>$upUrl,
            'album_id' => $id,
        ];
       Photo::create(array_merge($request->all(),$data));

        return redirect('home/photo-1'.'/'.$id);
    }

    public function photo($id)
    {
        $users = User::where('id','>','0')->get();
        $album = Album::where('id','=',$id)->get();
        $photo =Photo::where('album_id','=',$id)->orderBy('id','desc')->get();
        while($photo){
            return view('home/photo-1',compact('photo','id','album','users'));
        }
    }


    public function zan($id)
    {
        $user = Auth::user()->id;
        $says = Say::where('id','=',$id)->get();
        $users = $says->toArray();
        $users_id = $users[0]['users_id'];
        $zan=Zan::where('users_id','=',$users_id)->where('zsay_id','=',$id)->get();
        if (!$zan->isEmpty()){
            $zans = $zan->toArray();
            if (!empty($zans)){
                $zan_usebyid = $zans[0]['usersby_id'];
                if ($zan_usebyid==$user){
                    $zang=Zan::where('zsay_id','=',$id)->where('usersby_id','=',$user);
                    $zang->delete();
                }else{
                    $data=[
                        'users_id'=>$users_id,
                        'usersby_id'=>$user,
                        'zsay_id'=>$id,
                    ];
                    Zan::create($data);
                }
            }

        }else{
            $data=[
                'users_id'=>$users_id,
                'usersby_id'=>$user,
                'zsay_id'=>$id,
            ];
            Zan::create($data);
        }
        return redirect('home/personal');
    }

    public function other_per($id)
    {
        //根据模型将所以的数据查询出来
        $hui =Hui::where('id','>','0')->orderBy('id','desc')->get();
        $zan = Zan::where('id','>','0')->get();
        $say =Say::where('users_id','=',$id)->orderBy('id','desc')->get();
        $commit =Commit::where('id','>','0')->orderBy('id','desc')->get();
        $users_id = DB::select('select * from say where users_id = '.$id);
        $count_weibo =count($users_id);
        $users = User::where('id','=',$id)->get();
        $follow = Follow::where('users_id','=',$id)->get();
        $follows = Follow::where('usersby_id','=',$id)->get();
        $count_fans = count($follows);
        while($say){
            return view('home.other_vip',compact('say','commit','hui','zan','count_weibo','users','follow','count_fans'));
        }
    }

    public function guanzhu(Request $request,$id)
    {
        $data=[
            'users_id'=>$id,
        ];
        Follow::create(array_merge($request->all(),$data));

        return redirect('home/other_per'.'/'.$id);
    }

    public function nozhu(Request $request,$id)
    {
        $users_id = $request->input('users_id');
        $follow = Follow::where('users_id','=',$users_id)->where('usersby_id','=',$id);
        $follow->delete();
        return redirect('home/other_per'.'/'.$users_id);
    }

    public function vip_follow()
    {
        $id = Auth::user()->id;
        $follows = Follow::where('usersby_id','=',$id)->get();
    //    $follow = Follow::where('id','>','0')->get();
        $users = User::where('id','>','0')->get();
        $count_follows = count($follows);
        return view('home.vip_follow',compact('follows','users','count_follows'));
    }

    public function vip_fans()
    {
        $id = Auth::user()->id;
        $follows = Follow::where('users_id','=',$id)->get();
      /*  $follow = Follow::where('id','>','0')->get();*/
        $users = User::where('id','>','0')->get();
        $count_fans = count($follows);
        return view('home.vip_fans',compact('follows','users','count_fans'));
    }

    public function collection($id)
    {

        $user = Auth::user()->id;
        $says = Say::where('id','=',$id)->get();
        $users = $says->toArray();
        $users_id = $users[0]['users_id'];
        $collection = Collection::where('say_id','=',$id)->get();
        if (!$collection->isEmpty()){
            $collections = $collection->toArray();
            if (!empty($collections)){
                $coll_usebyid = $collections[0]['usersby_id'];
                if ($coll_usebyid==$user){
                    $coll=Collection::where('say_id','=',$id)->where('usersby_id','=',$user);
                    $coll->delete();
                }else{
                    $data=[
                        'users_id'=>$users_id,
                        'usersby_id'=>$user,
                        'say_id'=>$id,
                    ];
                    Collection::create($data);
                }
            }

        }else{
            $data=[
                'users_id'=>$users_id,
                'usersby_id'=>$user,
                'say_id'=>$id,
            ];
            Collection::create($data);
        }


        return redirect('home/personal');

    }

}
