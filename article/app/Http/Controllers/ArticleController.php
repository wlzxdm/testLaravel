<?php

namespace App\Http\Controllers;

use App\Article;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 列表
    public function index(){
        // 所有记录
//        $articles = Article::get();
        // 分页获取
        $articles = Article::paginate(3);
        return view('article.index',[
            'arts' => $articles
        ]);
    }

    /** 添加文章
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request){
        if($request->isMethod('POST')){
            // 数据验证
            $this->validate($request,[
                'Article.title' => 'required|min:5:max:100',
                'Article.content' => 'required'
            ],[
                'required' => ':attribute 为必填项',
                'min' => ':attribute 不符合最小长度',
                'max' => ':attribute 超出最大长度'
            ],[
                'Article.title' => '文章标题',
                'Article.content' => '文章内容'
            ]);



            $data = $request->input('Article');
            $article = new Article();
            $article->title = $data['title'];
            $article->content = $data['content'];
//            $article->create_at = date('Y-m-d H:i:s',time());
            
            if($article->save()){
                return redirect('article/index')->with('success','添加成功');
            }else{
                return redirect()->back()->with('error','添加失败');
            }
        }
        return view('article.add');
    }

    /** 修改文章
     * @param $id 文章ID
     * @return view
     */
    public function update(Request $request, $id){
        $article = Article::find($id);

        if($request->isMethod('POST')){
            // 数据验证
            $this->validate($request,[
                'Article.title' => 'required|min:5:max:100',
                'Article.content' => 'required'
            ],[
                'required' => ':attribute 为必填项',
                'min' => ':attribute 不符合最小长度',
                'max' => ':attribute 超出最大长度'
            ],[
                'Article.title' => '文章标题',
                'Article.content' => '文章内容'
            ]);

            $data = $request->input('Article');
            $article->title = $data['title'];
            $article->content = $data['content'];

            if($article->save()){
                return redirect('article/index')->with('success','修改成功');
            }else{
                return redirect()->back()->with('error','修改失败');
            }

        }
        return view('article.update',[
            'article' => $article
        ]);
    }

    /** 文章删除
     * @param $id 文章ID
     * @return view
     */
    public function delete($id){
        $article = Article::find($id);

        if($article->delete()){
            return redirect('article/index')->with('success','删除成功');
        }else{
            return redirect()->back()->with('error','删除成功');
        }
    }

    public function ajaxAdd(Request $request){
        if($request->isMethod('POST')){
            // 数据验证
            $this->validate($request,[
                'Article.title' => 'required|min:5:max:100',
                'Article.content' => 'required'
            ],[
                'required' => ':attribute 为必填项',
                'min' => ':attribute 不符合最小长度',
                'max' => ':attribute 超出最大长度'
            ],[
                'Article.title' => '文章标题',
                'Article.content' => '文章内容'
            ]);


            $data = $request->input('Article');
            $article = new Article();
            $article->title = $data['title'];
            $article->content = $data['content'];
//            $article->create_at = date('Y-m-d H:i:s',time());

            if($article->save()){
                echo json_encode([
                    'status' =>true,
                    'msg' => '添加成功'
                ]);
                exit;
            }else{
                echo json_encode([
                    'status'=>false,
                    'msg' => '添加失败'
                ]);
                exit;
            }
        }
        return view('article.ajaxAdd');
    }

}
