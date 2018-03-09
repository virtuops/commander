<?php

require_once __DIR__.'/../utils/Log.php';

Class GetRESTXML {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $url, $headers, $username, $password , $method, $data=false, $reststartproperty, $xml, $chartdscolx, $chartdscoly, $chartdscolz)
        {
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetRESTGridData($action, $reststartproperty, $url, $headers, $username, $password , $method, $data=false, $xml);
			return $data;
                } 
                if ($action == 'getchartdata') {
                        $data = $this->GetRESTChartData($reststartproperty, $url, $headers, $username, $password , $method, $data=false, $xml, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
        }

	private function GetRESTGridData($action, $reststartproperty, $url, $headers, $username, $password, $method, $data=false, $xml) {

                $curl = curl_init();

                $method = 'GET';

                switch ($method)
                {
                    case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);

                        if ($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    case "PUT":
                        curl_setopt($curl, CURLOPT_PUT, 1);
                        break;
                    default:
                        if ($data)
                            $url = sprintf("%s?%s", $url, http_build_query($data));
                }

                // Optional Authentication:
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($curl, CURLOPT_HTTPHEADER, array($headers));

                $result = curl_exec($curl);
                curl_close($curl);

		if ($action == 'getgriddata') {
		$result = $xml->GetOperation('getgridrestxml',null,$reststartproperty,null,null,null,$result);
		return $result;
		} else {
		$result = $xml->GetOperation('refreshgridrestxml',null,$reststartproperty,null,null,null,$result);
		}






	}

	private function GetRESTChartData($reststartproperty, $url, $headers, $username, $password , $method, $data=false, $xml, $chartdscolx, $chartdscoly, $chartdscolz) {

                $curl = curl_init();
                $method = 'GET';

                switch ($method)
                {
                    case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);

                        if ($data)
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        break;
                    case "PUT":
                        curl_setopt($curl, CURLOPT_PUT, 1);
                        break;
                    default:
                        if ($data)
                            $url = sprintf("%s?%s", $url, http_build_query($data));
                }

                // Optional Authentication:
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($curl, CURLOPT_HTTPHEADER, array($headers));

                $result = curl_exec($curl);
                curl_close($curl);

		$result = $xml->GetOperation('getchartrestxml',null,$reststartproperty,$chartdscolx,$chartdscoly,$chartdscolz,$result);
		return $result;


		
     } 
}
