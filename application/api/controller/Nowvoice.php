<?php


namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 示例接口
 */
class Nowvoice extends Api
{

    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['test','test1','index','addListen','voiceTypeList','countList','getFriendList'];
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


    /**
     * 列表带分页+筛选+搜索
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $where = [];
        $params = $this->request->param();
        $typeId = $params['type_id'] ?? "";
        $voice_name = $params['voice_name'] ?? "";
        $page = $params['page'] ?? 1;
        $pageSize = $params['page_size'] ?? 10;
        $limit = ($page-1)*$pageSize;


        if($typeId){
            $where['voice_type'] = $typeId;
        }
        if($voice_name){
            $where['voice_name'] = ['like',"%".$voice_name."%"];
        }

        $indexList = Db::name('nowvoice')
            ->where($where)
            ->limit($limit,$pageSize)
            ->field('id,voice_name,voice_type,background_img,background_video,voice,voice_listen_num')->select();
        $count = count($indexList);


        $this->success('success', [
            'list' => $indexList,
            'count' => $count,
            'page' => $page,
            'pageSize' => $pageSize,
            'limit' => $limit,
        ]);
    }

    public function addListen()
    {
        $where = [];
        $params = $this->request->param();
        $voice_id = $params['id'];
        if(!$voice_id){
            $this->error("声音 id 不能为空 请检查入参",$params);
        }

        $where['id'] = $voice_id;
        Db::name('nowvoice')->where($where)->setInc('voice_listen_num');
        $this->success('success');
    }

    public function voiceTypeList()
    {
        // $params = $this->request->param();
        $list = Db::name('nowvoicetype')->field('id,type_id,type_name')->select();
        $count = count($list);

        $this->success('success', [
            'list' => $list,
            'count' => $count,
        ]);
    }

    public function countList()
    {
        $voiceCount = Db::name('nowvoice')->count();
        $sleepCount = Db::name('nowsleep')->count();

        $list = [
            'voiceCount' => $voiceCount,
            'sleepCount' => $sleepCount,
        ];

        $this->success('success',[
            'list' => $list,
        ]);
    }

    public function getFriendList()
    {
        $list = Db::name('nowfriend')->field('id,content,author')->select();
        $this->success('success',[
            'list' => $list,
        ]);
    }
}