<?php
	namespace PSCMEDIA;
	use Ratchet\MessageComponentInterface;
	use Ratchet\ConnectionInterface;
	require  dirname(__DIR__) . "/message.php";
	class Chat implements MessageComponentInterface {
	    protected $clients;
	    public function __construct() {
	        $this->clients = new \SplObjectStorage;
	    }
	    public function onOpen(ConnectionInterface $conn) {
	        // Store the new connection to send messages to later
	        $this->clients->attach($conn);
	        echo 'Server Started';
        	$querystring = $conn->httpRequest->getUri()->getQuery();
        	parse_str($querystring, $queryarray);
	        if(isset($queryarray['active'])){
		        $message = new \Message;
	            $message->update_online($queryarray['active'],"online");
	            $jsondata = [
		        	"active" => $queryarray['active'],
		        	"type" => 'online',
		        	"content" => 'Đang truy cập',
		        ];
	            foreach ($this->clients as $client) {
		            $client->send(json_encode($jsondata));
		        }
	        }
            echo $queryarray['active'] . " New connection! ({$conn->resourceId})\n";
	    }
	    public function onMessage(ConnectionInterface $from, $msg) {
	        $numRecv = count($this->clients) - 1;
	        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
	        $data = json_decode($msg, true);
	        if($data['type']=='content'){
	        	$message = new \Message;
		        $getcount = $message->send($data);
		        $jsondata = [
		        	"active" => $data['active'],
		        	"receiver" => $data['receiver'],
		        	"content" => $data['content'],
		        	"type" => $data['type'],
		        	"count" => $getcount,
		        ];
		        foreach ($this->clients as $client) {
		            $client->send(json_encode($jsondata));
		        }
	        }
	        if($data['type']=='views'){
	        	$message = new \Message;
		        $message->select($data);
	        }
	        if($data['type']=='user'){
	        	$message = new \Message;
		        $select = $message->get_user($data);
		        $jsondata = [
		        	"active" => $data['active'],
		        	"receiver" => $data['receiver'],
		        	"type" => $data['type'],
		        	"data" => $select,
		        ];
		        foreach ($this->clients as $client) {
		            $client->send(json_encode($jsondata));
		        }
	        }
	        if($data['type']=='select'){
	        	$message = new \Message;
		        $select = $message->select($data);
		        $jsondata = [
		        	"active" => $data['active'],
		        	"receiver" => $data['receiver'],
		        	"type" => $data['type'],
		        	"data" => $select,
		        ];
		        foreach ($this->clients as $client) {
		            $client->send(json_encode($jsondata));
		        }
	        }
	    }
	    public function onClose(ConnectionInterface $conn) {
	        $this->clients->detach($conn);
	         echo 'Server Started';
        	$querystring = $conn->httpRequest->getUri()->getQuery();
        	parse_str($querystring, $queryarray);
	        if(isset($queryarray['active'])){
	        	$user_object = new \Message;
            	$user_object->update_online($queryarray['active'],"offline");
            	$jsondata = [
		        	"active" => $queryarray['active'],
		        	"type" => 'offline',
		        	"content" => 'Đang ngoại tuyến',
		        ];
	            foreach ($this->clients as $client) {
		            $client->send(json_encode($jsondata));
		        }
            }
	        echo "Connection {$conn->resourceId} has disconnected\n";
	    }
	    public function onError(ConnectionInterface $conn, \Exception $e) {
	        echo "An error has occurred: {$e->getMessage()}\n";
	        $conn->close();
	    }
	}
?>