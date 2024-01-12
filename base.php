<?php
namespace BD_KDD;
class BD {
    private const ServerName = 'localhost';
    private const UserName = 'kanev_kurs_k';
    private const pass = 'qrjPEVOcR96lsFwO';
    private const DbName = 'kanev_kurs_k';
    protected $appid = 51829603;
    protected $productkey = "St9PxI0tDajXW6Rxat8H";
    protected $token;
    protected $url = "https://kanev.kurs.kosipov.ru/2048.php";
    protected $sd ="1bQ7b9y1Wz28bFtseGOOvd18jrqu2tw7QvO5";

    

    private $conn;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = \mysqli_connect(self::ServerName, self::UserName, self::pass, self::DbName);;
        
        if(!$conn){
            die("conection faild:" . \mysqli_connect_error());
        };

        $this->conn = $conn;

    } 
    public function login($log, $pass)
    {
        //$pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM `users` WHERE `login` = '$log'";
        $rows = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($rows);
        //return($result);
        if($pass == $result['pass'])
        {
            return(1);
        }else{
            return(0);
        }


    }

    public function URL()
    {
        $sd = $this->sd;
        $appid = $this->appid;
        $productkey = $this->productkey;
        $url = $this->url;
        $auth = "https://id.vk.com/auth?uuid=$sd&app_id=$appid&response_type=silent_token&redirect_uri=$url";
        return($auth);
    }

    public function git_url()
    {
        $params = array(
            'client_id'     => 'a25fb8bb740b41ace5c8',
            'redirect_uri'  => 'https://kanev.kurs.kosipov.ru/2048.php',
            'scope'         => 'user',
            'response_type' => 'code',
            'state'         => 'Git'
        );
        $url = 'https://github.com/login/oauth/authorize?' . urldecode(http_build_query($params));
        return($url);
    }

    public function yandex_url()
    {
        $params = array(
            'client_id'     => 'f8e29bd85f1d40a2997b1775940d0afc',
            'redirect_uri'  => 'https://kanev.kurs.kosipov.ru/2048.php?',
            'response_type' => 'code',
            'state'         => 'yandex'
        );
         
        $url = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));
        return($url);
        
    }

    public function name_github($code)
    {
        $params = array(
			'client_id'     => 'a25fb8bb740b41ace5c8',
			'client_secret' => '1df45f37d18d3393d527dec79b929c8e0b7e59b4',
			'redirect_uri'  => 'https://kanev.kurs.kosipov.ru/2048.php',
			'code'          => $code
		);	
				
		$ch = curl_init('https://github.com/login/oauth/access_token');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($params))); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$data = curl_exec($ch);
		curl_close($ch);	
		parse_str($data, $data);
	 
		if (!empty($data['access_token'])) {
			$ch = curl_init('https://api.github.com/user');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: token ' . $data['access_token']));
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$info = curl_exec($ch);
			curl_close($ch);
			$info = json_decode($info, true);
	 
			if (!empty($info['id'])) {
				return($info);
			}
		} 
    }

    public function yandex_name($code)
    {
        $params = array(
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => 'f8e29bd85f1d40a2997b1775940d0afc',
            'client_secret' => '4a519986d0464dd683e234d4c754f85e',
        );
        
        $ch = curl_init('https://oauth.yandex.ru/token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $data = curl_exec($ch);
        curl_close($ch);	
                 
        $data = json_decode($data, true);
        if (!empty($data['access_token'])) {
            // Токен получили, получаем данные пользователя.
            $ch = curl_init('https://login.yandex.ru/info');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json')); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $data['access_token']));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $info = curl_exec($ch);
            curl_close($ch);
     
            $info = json_decode($info, true);
            return($info);
        }
    }

    private function check_user_vk($id)
    {
        $sql = "SELECT * FROM `users` WHERE `id_vk` = $id";
        $rows = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($rows);
        if($result == null)
        {
            return(0);
        }else{
            return(1);
        }
    }


    public function new_user_VK($id, $name)
    {
        $check = $this->check_user_vk($id);
        if($check ==0)
        {
            $sql = "INSERT INTO `users` (`id`, `login`, `pass`, `name`, `id_vk`) VALUES (NULL, NULL, NULL, '$name', '$id')";
            mysqli_query($this->conn, $sql);
        }else
        {
            return;
        }
    }

    private function check_name($name){
        $sql = "SELECT * FROM `users` WHERE `name` = '$name'";
        $rows = mysqli_query($this->conn, $sql);
        $result = mysqli_fetch_assoc($rows);
        return($result);
    }


    public function registration($log, $pass, $name)
    {
        $check = $this->check_name($name);
        //$pass = password_hash($pass, PASSWORD_DEFAULT);
        if($check == null)
        {
            $sql = "INSERT INTO `users` (`id`, `login`, `pass`, `name`, `id_vk`) VALUES (NULL, '$log', '$pass', '$name', NULL)";
            mysqli_query($this->conn, $sql);
            $result = "вернитесь к авторизации";
        } else
        {
            $result = "такой ник занят";
        }
        
        return($result);

    }


    public function record()
    {
       $sql= "SELECT * FROM `record` ORDER BY `record`.`weight` DESC";
       $rows = mysqli_query($this->conn, $sql);
       $result = mysqli_fetch_all($rows);
       $check = count($result);
        for($row = 0; $row <= $check; $row++)
        {
        $return[$row]['name'] = $result[$row][1];
        $return[$row]['weight'] = $result[$row][2];
        }
       return($return);
    }


    public function result($result)
    {
        for($row =1; $row <= 20; $row++)
        {
            $check = pow(2, $row);
            if($check == $result)
            {
                if($check == 1048576)
                {
                    $return = "<h3>Это невозможно.У тебя либо очень много свободного времен, либо ты читеришь. Подумай ещё раз</h3>";
                    return($return);
                };
            $return = $result;
            return($return);    
            }else
            {
                $return = "невозможно записать результат";
            }
        }
        return($return);
        
    }

    public function write_result($result, $name)
    {
        $sql = "INSERT INTO `record` (`id`, `name`, `weight`, `time`) VALUES (NULL, '$name', '$result', NULL)";
        mysqli_query($this->conn, $sql);
        
    }

    //"https://id.vk.com/auth?uuid=1bQ7b9y1Wz28bFtseGOOvd18jrqu2tw7QvO5&app_id=51829603&response_type=silent_token&redirect_uri=https://kanev.kurs.kosipov.ru/2048.html"


    
}