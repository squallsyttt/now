<?php


namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 示例接口
 */
class Nowsleep extends Api
{

    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['test', 'test1','index'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = ['test2'];

    /**
     * 测试方法
     *
     * @ApiTitle    (测试名称)
     * @ApiSummary  (测试描述信息)
     * @ApiMethod   (POST)
     * @ApiRoute    (/api/demo/test/id/{id}/name/{name})
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiParams   (name="id", type="integer", required=true, description="会员ID")
     * @ApiParams   (name="name", type="string", required=true, description="用户名")
     * @ApiParams   (name="data", type="object", sample="{'user_id':'int','user_name':'string','profile':{'email':'string','age':'integer'}}", description="扩展数据")
     * @ApiReturnParams   (name="code", type="integer", required=true, sample="0")
     * @ApiReturnParams   (name="msg", type="string", required=true, sample="返回成功")
     * @ApiReturnParams   (name="data", type="object", sample="{'user_id':'int','user_name':'string','profile':{'email':'string','age':'integer'}}", description="扩展数据返回")
     * @ApiReturn   ({
    'code':'1',
    'msg':'返回成功'
    })
     */
    public function test()
    {
        $this->success('返回成功breath', $this->request->param());
    }

    /**
     * 无需登录的接口
     *
     */
    public function test1()
    {
        $this->success('返回成功', ['action' => 'test1']);
    }

    /**
     * 需要登录的接口
     *
     */
    public function test2()
    {
        $this->success('返回成功', ['action' => 'test2']);
    }

    /**
     * 需要登录且需要验证有相应组的权限
     *
     */
    public function test3()
    {
        $this->success('返回成功', ['action' => 'test3']);
    }


    public  function index()
    {
        $likeWhere = [];
        $params = $this->request->param();
        $page = $params['page'] ?? 1;
        $pageSize = $params['page_size'] ?? 10;
        $limit = ($page-1)*$pageSize;
        $like = $params['like'] ?? [];
        $likeList = [];

        if($page == 1 && count($like)>0){
            $likeWhere['id'] = ['in',$like];
            $likeList = Db::name('nowsleep')
                ->where($likeWhere)
                ->field('id,sleep_name,sleep_background_img,sleep_voice,sleep_listen_num')->select();
        }

        $indexList = Db::name('nowsleep')
            ->limit($limit,$pageSize)
            ->field('id,sleep_name,sleep_background_img,sleep_voice,sleep_listen_num')->select();
        $count = count($indexList);

        if($page == 1){
            $indexList = array_merge($likeList,$indexList);
            $count = count($indexList);
        }

        $this->success('success', [
            'list' => $indexList,
            'count' => $count,
            'page' => $page,
            'pageSize' => $pageSize,
            'limit' => $limit,
        ]);
    }

}
