<?php


class irc{
	public $host  	= '';
	public $port  	= 0;
	public $nick 	= '';
	public $user  	= '';
	public $rfeed 	= 0;
	public $channel = '#ism';

	public function __construct($host,$port,$nick,$user,$ssl = 0){
		$this->host = $host;
		$this->port = $port;
		$this->nick = $nick;
		$this->user = $user;
		$this->psb  = new psb();
		$this->rss  = new rss();
		$this->count = $this->rss->feeds;

		//cjecl if ssl is 0 or not if not use ssl

		if($ssl == 0){
			$this->sock = fsockopen($this->host,$this->port,$this->errno,$this->errstr,2) or die($this->errno . $this->errstr);

		}else{ 	$this->sock = fsockopen('ssl://'. $this->host,$this->port,$this->errno,$this->errstr,2) or die($this->errno . $this->errstr);}

		//identify with irc
		$this->ident();

		//join channel
		$this->join($this->channel);

		//while the irc sock is still alive
		while($this->sock){

			//get data from the socket
			$stuff = fgets($this->sock);

			//split into an array
			$data = explode(' ', $stuff);
			//print data
			print $stuff;
			if($this->rfeed == 1){

				if(count($this->count) == 0){$this->count = $this->rss->feeds;}else{
					$this->rss->setFeed($this->count[0]);
					foreach($this->rss->PrettyRss() as $feeds){
						$this->privmsg($data[2],implode(' ', $feeds));

					}

				}

			}
			//check if the irc server pinged or not
			if ($data[0]=='PING') {

				//respond to ping
				$this->pong($data[1]);

			}else{
				//if not a ping
				switch ($data[3]) {
					//check if the 4th value of the array $data is :!say
					case ':!say':
							//send to the chan the 5 value
							$this->privmsg($data[2],$data[4]);
						break;
					case ':!leaklookup':

							foreach($this->psb->mail(trim(preg_replace('/\s+/', ' ', $data[4]))) as $paste){
								$this->privmsg($data[2],$paste);
								sleep(1);
							}
						break;
					case ':!dailydump':

							foreach($this->psb->daily() as $paste){
								$this->privmsg($data[2],$paste);
								sleep(1);
							}
						break;
					case ':!domainlookup':
							foreach($this->psb->domain(trim(preg_replace('/\s+/', ' ', $data[4]))) as $paste){
								$this->privmsg($data[2],$paste);
								sleep(1);

							}
						break;
					case ':!rss':
							if($this->rfeed == 1){ $this->rfeed = 0; $this->privmsg($data[2],'Rss turned off');}
							else{	$this->rfeed = 1; $this->privmsg($data[2],'Rss turned on');}
					//default do nothing
					default:
						break;
				}
			}


		}
	}

	private function pong($data){
		//respond to pings
		fputs($this->sock,"PONG $data\r\n");
	}

	//send a message to channel or person
	public function privmsg($c,$d){

		fputs($this->sock,"PRIVMSG $c :$d\r\n");
	}

	private function ident(){
		//send nick and user to irc
		fputs($this->sock,"NICK $this->nick\r\n");
		fputs($this->sock,"USER $this->user\r\n");

		while($d = fgets($this->sock)){
			if (preg_match('/004/', $d)) {
				break;
			}elseif (preg_match('/433/', $d)) {
				die('Nick in use');
			}elseif (preg_match('/PING/', $d)) {
				$pong = explode(' ', $d);
				$this->pong($pong[1]);
			}
		}
	}
	//join chan
	public function join($c){
		fputs($this->sock,"JOIN $c \r\n");
	}

}

//$test = new irc('test',str_repeat("poop ", 4));

?>
