<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Comments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function get_comments(Request $request)
    {
        $type = $request->get('status');
        $typeData = [ 'type' => $type ];
        $paramType = Comments::findStatusOnParam($type);
        if ($request->get('post'))
            $typeData = array_merge([ 'post_id' => $request->get('post') ], $typeData);
        $options = [
            'with'       => 'post',
            'withSelect' => ['post_id','title','url']
        ];
        $data = Comments::getCommentsWithCount(array_merge($paramType, $options), $typeData);
        return view('rix.comments')->with([
            'comments' => $data['comments'],
            'typeData' => $data['count']
        ]);
    }
}
