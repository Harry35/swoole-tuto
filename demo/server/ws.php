<?php

class Ws {
    const HOST = "0.0.0.0";
    const PORT = 9502;

    public $ws = null;
    public function __construct() {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2
        ]);
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request) {
        var_dump($request->fd);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $request
     */
    public function onMessage($ws, $frame) {
        echo "server-push-message: {$frame->data}\n";
        //todo 10s
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
        $ws->task($data);
        $ws->push($frame->fd, "server-push: ".date("Y-m-d H:i:s"));
    }

    /**
     * 监听任务投递
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     */
    public function onTask($serv, $taskId, $workerId, $data) {
        print_r($data);
        //耗时场景 10s
        sleep(10);
        return "on task finish";
    }

    /**
     * 监听任务结束
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data) {
        echo "taskId: {$taskId}\n";
        echo "finish-data-success: {$data}\n";
    }

    /**
     * 监听ws关闭事件
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
        echo "clientid: {$fd}\n";
    }
}

$obj = new Ws();