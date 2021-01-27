<?php

class ApiParser_V2
{
	var $settings = array ();

	/** Production **/
   	var $URL = 'https://api.mailmailmail.net/v2.0/';




	public function __construct ($settings = array())
	{
		$this->settings = $settings;
	}

	protected function GetHTTPHeader ()
	{
		switch($this->settings["format"])
		{
			case "xml":
				return array (
						"Accept: application/xml; charset=utf-8",
						"Apiusername: " . $this->settings['username'],
						"Apitoken: " . $this->settings['token']
				);
			break;
			case "serialized":
				return array (
						"Accept: application/vnd.php.serialized; charset=utf-8",
						"Apiusername: " . $this->settings['username'],
						"Apitoken: " . $this->settings['token']
				);
			break;
			case "php":
				return array (
						"Accept: application/vnd.php; charset=utf-8",
						"Apiusername: " . $this->settings['username'],
						"Apitoken: " . $this->settings['token']
				);
			break;
			case "csv":
				return array (
						"Accept: application/csv; charset=utf-8",
						"Apiusername: " . $this->settings['username'],
						"Apitoken: " . $this->settings['token']
				);
			break;
			default:
				return array (
						"Accept: application/json; charset=utf-8",
						"Apiusername: " . $this->settings['username'],
						"Apitoken: " . $this->settings['token']
				);
			break;
		}
	}

	private function DecodeResult ($input = '')
	{
		switch($this->settings["format"])
		{
			case "xml":
				// @todo implement parser
				return $input;
			break;
			case "serialized":
				// @todo implement parser
				return $input;
			break;
			case "php":
				// @todo implement parser
				return $input;
			break;
			case "csv":
				// @todo implement parser
				return $input;
			break;
			default:
				return json_decode($input, TRUE);
			break;
		}
	}

	private function MakeGetRequest ($url = "", $fields = array())
	{
		// open connection
		$ch = curl_init();
			
		if(!empty($fields))
		{
			$url .= "?" . http_build_query($fields, '', '&');
		}

		// set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->GetHTTPHeader());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		// disable for security
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		// execute post
		$result = curl_exec($ch);
		
		// close connection
		curl_close($ch);

		return $this->DecodeResult($result);
	}

	private function MakePostRequest ($url = "", $fields = array())
	{
		try
		{
			// open connection
			$ch = curl_init();
			
			// add the setting to the fields
// 			$data = array_merge($fields, $this->settings);

			$encodedData = http_build_query($fields, '', '&');

			// set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->GetHTTPHeader());
			curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			// disable for security
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
			// execute post
			$result = curl_exec($ch);
			
			// close connection
			curl_close($ch);
			return $this->DecodeResult($result);
		}
		catch(Exception $error)
		{
			return $error->GetMessage();
		}
	}

	private function MakeDeleteRequest ($url = "", $fields = array())
	{
		try
		{
			// open connection
			$ch = curl_init();
			
			// add the setting to the fields
			// 			$data = array_merge($fields, $this->settings);
			
// 			$encodedData = http_build_query($fields, '', '&');

			$fields = json_encode($fields);
			// set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->GetHTTPHeader());
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			// disable for security
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
			// execute post
			$result = curl_exec($ch);
			
			// close connection
			curl_close($ch);
			return $this->DecodeResult($result);
		}
		catch(Exception $error)
		{
			return $error->GetMessage();
		}
	}
	
	private function MakePutRequest ($url = "", $fields = array())
	{
			// open connection
		$ch = curl_init();
		
		$encodedData = http_build_query($fields, '', '&');
		
		// set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->GetHTTPHeader());
		curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		// disable for security
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		// execute post
		$result = curl_exec($ch);
		
		// close connection
		curl_close($ch);
		return $this->DecodeResult($result);
	}

	//testing methods start
	
	
	
	public function HasRequirements ()
	{
		if(!is_callable('curl_init'))
		{
			return 'curl is not installed correctly!';
		}
		
		$params = array (
				"test" => "a"
		);
		$url = $this->URL . "/Test";
		
		$result = $this->MakePostRequest($url, $params);
		if(!array_key_exists('postResponse', $result))
		{
			return 'Post request not work properly';
		}
		
		$result = $this->MakeDeleteRequest($url, $params);
		if(!array_key_exists('deleteResponse', $result))
		{
			return 'Delete request not work properly';
		}
		return 'All requirements work correctly';
	}
	
	public function TestUserToken()
	{
		$url = $this->URL . "/Test/TestUserToken";
		return $this->MakePostRequest($url);
	}
	
	public function EmptyGET($param = "")
	{
		$url = $this->URL . "/Test/EmptyGET";
		$param = array (
				'test' => $param
		);
		return $this->MakeGetRequest($url, $param);
	}
	
	public function EmptyPOST($param = "")
	{
		$url = $this->URL . "/Test/EmptyPOST";
		$param = array (
				'test' => $param
		);
		return $this->MakePostRequest($url, $param);
	}
	

	/**
	     * AddProfileToList
	     * Adds a profile to a list.
	     * Checks whether the list actually exists. If it doesn't, returns an error.
	     *
	     * @param Int listid
	     *        	The list to add the profile to.
	     * @param String emailaddress
	     *        	Profile address to add to the list.
	     * @param String mobileNumber
	     *        	Profile mobile phone to add to list.
	     * @param String mobilePrefix
	     * 			Profile country calling code.
         * @param Boolean confirmed
	     * 			Whether to add the profile as confirmed or not
	     * @param Boolean addToAutoresponders
	     *        	Whether to add the profile to the lists' autoresponders or
	     *        	not.
	     */
	public function AddProfileToList(int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "", bool $confirmed = true, bool $addToAutoresponders = false)
	{
		$url = $this->URL . '/Profiles/AddProfileToList';
		
		$params = array (
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'confirmed' => $confirmed,
				'addToAutoresponders' => $addToAutoresponders
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
        * ResubscribeProfile
        * Resubscribe deleted profile
        *
        * @param String emailaddress
        *        	Email address of profile
        * @param String mobileNumber
        *           Mobile number of profile
        * @param String mobilePrefix
        *           Country calling code
        * @param Boolean addToAutoresponders
        * 		    Whether to add to autoresponder or not
        *
        */
	public function ResubscribeProfile (string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "", bool $addToAutoresponders = false)
	{
		$url = $this->URL . '/Profiles/ResubscribeProfile';
		
		$params = array (
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'addToAutoresponders' => $addToAutoresponders
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
         * GetSnapshots
         * Get all snapshots for particular profile, trigger, autoresponder or newsletter
         *
         * @param Int profileid
         *        	Id of profile
         * @param Int triggerid
         *        	Id of trigger
         * @param Int autoresponderid
         *        	Id of autoresponder
         * @param Int newsletterid
         *        	Id of newsletter     	
         * @param String groupBy
         *        	To group by date or type       		
         *        	
         */
	public function GetSnapshots(int $profileid = 0, int $triggerid = 0, int $autoresponderid = 0, int $newsletterid = 0, string $groupBy = 'date')
	{
		$url = $this->URL . '/Stats/GetSnapshots';
		
		$params = array (
				'profileid' => $profileid,
				'triggerid' => $triggerid,
				'autoresponderid' => $autoresponderid,
				'newsletterid' => $newsletterid,
				'groupBy' => $groupBy
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * UnsubscribeProfileEmail
        * Unsubscribe emails for particular profile
        *
        * @param Int listid
        *        	Id of the list
        * @param String emailaddress
        *        	Email Address of profile
        * @param Int profileid
        *        	Id of the profile
        * @param Int profileid
        *        	Stat id to check.
        */
	public function UnsubscribeProfileEmail (int $listid = 0, string $emailaddress = "", int $profileid = 0,  int $statid = 0)
	{
		$url = $this->URL . '/Profiles/UnsubscribeProfileEmail';
		
		$params = array (
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'profileid' => $profileid,
				'statid' => $statid
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
	     * UnsubscribeProfileMobile
	     * Unsubscribe sms for particular profile
	     *
	     * @param Int listid
	     *        	Id of the list
	     * @param String mobileNumber
	     *        	Mobile number to unsubscribe.
	     * @param String mobilePrefix
	     *        	Country calling code.
	     * @param Int profileid
	     *        	Id of the profile
         * @param Int statid
         *      	Stat id to check.
         *        	
	     */
	public function UnsubscribeProfileMobile (int $listid = 0, string $mobileNumber = "", string $mobilePrefix = "", int $profileid = 0, int $statid = 0)
	{
		$url = $this->URL . '/Profiles/UnsubscribeProfileMobile';
		
		$params = array (
				'listid' => $listid,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'profileid' => $profileid,
				'statid' => $statid
		);
		
		return $this->MakePostRequest($url, $params);
	}
	

        /**
        * GetProfileDetails
        * Load basic information for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int listid
        *           Id of the list which is profile
        * @param String emailaddress
        *           Email address of profile
        * @param String mobileNumber
        *           Mobile number of profile
        * @param String mobilePrefix
        * 			Country dialing code     	
        *
        */
	public function GetProfileDetails(int $profileid = 0, int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Profiles/GetProfileDetails';
		
		$params = array (
				'listid' => $listid,
				'profileid' => $profileid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * LoadProfileDataFields
        * Get data fields for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int listid
        *           Id of the list which is profile
        * @param String emailaddress
        *           Email address of profile
        * @param String mobileNumber
        *           Mobile number of profile
        * @param String mobilePrefix
        * 			Country dialing code     	
        *
        */
	public function LoadProfileDataFields(int $profileid = 0, int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Profiles/LoadProfileDataFields';
		
		$params = array (
				'profileid' => $profileid,
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * LoadProfileOTMFields
        * Get otm fields for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int listid
        *           Id of the list which is profile
        * @param String emailaddress
        *           Email address of profile
        * @param String mobileNumber
        *           Mobile number of profile
        * @param String mobilePrefix
        * 			Country dialing code     	
        *
        */
	public function LoadProfileOTMFields(int $profileid = 0, int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Profiles/LoadProfileOTMFields';
		
		$params = array (
				'profileid' => $profileid,
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * GetProfileBounces
          * Get bounces for profile
          * 
          * @param Int profileid
          *           Id of the profile
          * @param Int limit
          * 		   Number of records you want to fetch.
          * @param Int offset
          * 		   From where to start.     	
          *
          */
	public function GetProfileBounces(int $profileid = 0, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileBounces';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
	     * Save Profile Data field
	     * Saves data field information for a particular profile
	     * NOTE:
	     * - Any old data field data will be deleted.
	     * - NULL data values will not be saved to the database.
	     *
	     * @param Int profileid
	     *        	Id of the profile whose data need to be updated.
	     * @param Int fielid
	     *        	Id of the field
	     * @param Mixed fieldValue
	     *        	The actual data field value
	     * @param Boolean skipEmptyData
	     * 			  Won't be executed if field value is empty.
	     *
	     */
	public function SaveProfileDataField(int $profileid = 0, int $fielid = 0, $fieldValue = "", bool $skipEmptyData = false)
	{
		$url = $this->URL . '/Profiles/SaveProfileDataField';
		
		$params = array (
				'profileid' => $profileid,
				'fieldid' => $fielid,
				'fieldValue' => $fieldValue,
				'skipEmptyData' => $skipEmptyData
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
	     * AddToOTMDocument
	     * Add values in particular otm field
	     *
	     * @param Int profileid
	     *        	ID of the profile whose data need to be updated.
         * @param Int fieldid
	     *        	ID of the fieldid
	     * @param Array fieldValueOTM
	     *        	The actual data for otm values
	     * @param String path
	     * 			Path in otm field
	     *
	     */
	public function AddToOTMDocument (int $profileid = 0, int $fieldid = 0, array $fieldValueOTM = array(), string $path = "")
	{
		$url = $this->URL . '/Profiles/AddToOTMDocument';
		
		$params = array (
				'profileid' => $profileid,
				'fieldid' => $fieldid,
				'fieldValueOTM' => $fieldValueOTM,
				'path' => $path
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
        * UpdateOTMDocument
        * Update values in particular otm field
        *
        * @param Int profileid
        *        	ID of the profile whose data need to be updated.
        * @param Int fieldid
        *        	ID of the fieldid
        * @param Array fieldValueOTM
        *        	The actual data for update otm values
        * @param String path
        * 			Path in otm field
        *
        */
	public function UpdateOTMDocument (int $profileid = 0, int $fieldid = 0, array $fieldValueOTM = array(), string $path = "")
	{
		$url = $this->URL . '/Profiles/UpdateOTMDocument';
		
		$params = array (
				'profileid' => $profileid,
				'fieldid' => $fieldid,
				'fieldValueOTM' => $fieldValueOTM,
				'path' => $path
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	/**
        * RemoveOTMDocument
        * Remove values in particular otm field
        *
        * @param Int profileid
        *        	ID of the profile whose data need to be updated.
        * @param Int fieldid
        *        	ID of the fieldid
        * @param String path
        * 			Path in otm field
        * @param Int index
        *        	On which index to remove
        *
        */
	public function RemoveOTMDocument (int $profileid = 0, int $fieldid = 0, string $path = "", $index = 0)
	{
		$url = $this->URL . '/Profiles/RemoveOTMDocument';
		
		$params = array (
				'profileid' => $profileid,
				'fieldid' => $fieldid,
				'path' => $path,
				'index' => $index
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
	/**
	     * DeleteProfile
	     * Deletes a profile and their information from a particular list.
	     *
         * @param Int profileid
         *           Id of profile to delete
	     * @param Int listid
	     *        	List to delete them off.
	     * @param String emailaddress
	     *        	Email Address to delete.
	     * @param String mobileNumber
	     * 			Mobile to delete.
	     * @param String mobilePrefix
	     * 			Country calling code.
	     *.
	     */
	public function DeleteProfile(int $profileid = 0, int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Profiles/DeleteProfile';
		
		$params = array (
				'profileid' => $profileid,
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
		
	 /**
	     * IsProfileOnList
	     * Checks whether a profile is on a particular list based on their email
	     * address/mobile or profileid and whether you are checking only for active
	     * profiles.
	     *
	     * @param int listid
	     *        	Id of the list
	     * @param String emailaddress
	     *        	Email address to check for.
	     * @param String mobileNumber
	     *        	Mobile phone to check for.
	     * @param String mobilePrefix
	     * 			Country calling code.
	     * @param Int profileid
	     *        	Profile id. This can be used instead of the email address.
         *        	
	     */
	public function IsProfileOnList (int $listid = 0, string $emailaddress = "", string $mobileNumber = "", string $mobilePrefix = "", int $profileid = 0)
	{
		$url = $this->URL . "/Profiles/IsProfileOnList";
		
		$params = array (
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'profileid' => $profileid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesByDataField
        * Get profiles for particular data field
        * 
        * @param Int fieldid
        *           Id of the field
        * @param object fieldValue
        *           Which value to contain data field
        * @param Boolean activeOnly
        *           Whether to get only active profiles or not
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.        	
        *
        */
	public function GetProfilesByDataField ($fieldid = false, $fieldValue = false, $activeOnly = true, $countOnly = false, $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByDataField';
		
		$params = array (
				'fieldid' => $fieldid,
				'fieldValue' => $fieldValue,
				'activeOnly' => $activeOnly,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetProfilesByList
        * Get all profiles for particular list
        * 
        * @param Int listid
        *        	The listid for which to load the profiles.
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetProfilesByList (int $listid = 0, bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByList';
		
		$params = array (
				'listid' => $listid,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesByLinkClick
        * Get all profiles for particular link
        * 
        * @param Int linkid
        *        	The link id for which to load the profiles.
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetProfilesByLinkClick (int $linkid = 0, bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByLinkClick';
		
		$params = array (
				'linkid' => $linkid,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
       * GetProfilesByAutoresponder
       * Get all profiles for particular autoresponder
       * 
       * @param Int autoresponderid
       *        	The autoresponder id for which to load the profiles.
       * @param Boolean openOnly
       *           Whether to return only profiles which opened the autoresponder
       * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
       * @param Int limit
       * 			Number of records you want to fetch.
       * @param Int offset
       * 			From where to start.        	
       *
       */
	public function GetProfilesByAutoresponder (int $autoresponderid = 0, bool $openOnly = false, bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByAutoresponder';
		
		$params = array (
				'autoresponderid' => $autoresponderid,
				'openOnly' => $openOnly,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesByNewsletter
        * Get all profiles for particular newsletter
        * 
        * @param Int newsletterid
        *        	The newsletter id for which to load the profiles.
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Boolean type
        *           Which type for newsletter
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetProfilesByNewsletter (int $newsletterid = 0, string $type = "", bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'type' => $type,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesByEmail
        * Get all profiles for particular email
        * 
        * @param String emailaddress
        *        	The email address for which to load the profiles.
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records 
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetProfilesByEmail (string $emailaddress = "", bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByEmail';
		
		$params = array (
				'emailaddress' => $emailaddress,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetProfilesByMobile
        * Get all profiles for particular mobile
        * 
        * @param String mobileNumber
        *        	The mobile number for which to load the profiles.
        * @param String mobilePrefix
        *        	Country dialing code
        *@param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetProfilesByMobile (string $mobileNumber = "", string $mobilePrefix = "", bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByMobile';
		
		$params = array (
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
       * GetProfilesByDomain
       * Get all profiles for particular domain
       * 
       * @param String domain
       *        	The domain for which to load the profiles.
       * @param Boolean countOnly
       *           If specify true will return only number of how many records
       *           If specify false will return array of all records
       * @param Int limit
       * 			Number of records you want to fetch.
       * @param Int offset
       * 			From where to start.        	
       *
       */
	public function GetProfilesByDomain (string $domain = "", bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByDomain';
		
		$params = array (
				'domain' => $domain,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
       * GetActiveProfiles
       * Get all active profiles
       * 
       * @param Boolean countOnly
       *           If specify true will return only number of how many records
       *           If specify false will return array of all records
       * @param Int limit
       * 			Number of records you want to fetch.
       * @param Int offset
       * 			From where to start.        	
       *
       */
	public function GetActiveProfiles (bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetActiveProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * GetAllProfiles
          * Get all profiles
          * 
          * @param Boolean countOnly
          *           If specify true will return only number of how many records
          *           If specify false will return array of all records 
          * @param Int limit
          * 			Number of records you want to fetch.
          * @param Int offset
          * 			From where to start.        	
          *
          */
	public function GetAllProfiles (bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetAllProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
         * GetBouncedProfiles
         * Get bounced profiles
         * 
         * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
         * @param Int limit
         * 			Number of records you want to fetch.
         * @param Int offset
         * 			From where to start.        	
         *
         */
	public function GetBouncedProfiles (bool $countOnly = false, $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetBouncedProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
         * GetDisabledProfiles
         * Get disabled profiles
         * 
         * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records 
         * @param Int limit
         * 			Number of records you want to fetch.
         * @param Int offset
         * 			From where to start.        	
         *
         */
	public function GetDisabledProfiles (bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetDisabledProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
         * GetUnconfirmedProfiles
         * Get unconfirmed profiles
         * 
         * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *            If specify false will return array of all records
         * @param Int limit
         * 			Number of records you want to fetch.
         * @param Int offset
         * 			From where to start.        	
         *
         */
	public function GetUnconfirmedProfiles (bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetUnconfirmedProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetUnsubscribedProfiles
        * Get unsubscribed profiles
        * 
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records 
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.        	
        *
        */
	public function GetUnsubscribedProfiles (bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetUnsubscribedProfiles';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetProfilesBySMSStatus
        * Get profiles by sms status
        * 
        * @param Boolean active
        *           Whether to return active only or not
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.        	
        *
        */
	public function GetProfilesBySMSStatus (bool $active = true, bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesBySMSStatus';
		
		$params = array (
				'active' => $active,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetProfilesByRating
        * Get profiles for particular rating
        * 
        * @param String rating
        *           Rating for profile
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.        	
        *
        */
	public function GetProfilesByRating (string $rating = "", bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByRating';
		
		$params = array (
				'rating' => $rating,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesByDate
        * Get profiles for particular date
        * 
        * @param String startDate
        *           Date from
        * @param String endDate
        *           Date to
        * @param String type
        *           Type for date /after/before/between/exactly/not
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.        	
        *
        */
	public function GetProfilesByDate ($startDate = false, $endDate = false, $type = false, $countOnly = false, $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesByDate';
		
		$params = array (
				'startDate' => $startDate,
				'endDate' => $endDate,
				'type' => $type,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}

	/**
	     * RequestUpdateEmail
	     * Request to change current email address.
	     *
	     *
	     * @param Integer profileid
	     * 			Profile id to update.
	     * @param String oldEmail
	     * 			Current email address.
	     * @param String newEmail
	     * 			New email address.
	     *
	     * @return Integer Returns a status (true/false).
	     */
	public function RequestUpdateEmail(int $profileid = 0, string $oldEmail = '', string $newEmail = '')
	{
		$url = $this->URL . '/Profiles/RequestUpdateEmail';
		
		$params = array (
				'profileid' => $profileid,
				'oldEmail' => $oldEmail,
				'newEmail' => $newEmail
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
	     * IsUnsubscriberEmail
	     * Checks whether an email address is an 'unsubscriber' - they have
	     * unsubscribed from a list.
	     *
	     * @param Int listid
	     *        	List to check for.
	     * @param String emailaddress
	     *        	Email Address to check.
	     * @param Int profileid
	     *        	Subscriber id to check.
         *        	
	     */
	public function IsUnsubscriberEmail (int $listid = 0, string $emailaddress = "", int $profileid = 0)
	{
		$url = $this->URL . '/Profiles/IsUnsubscriberEmail';
		
		$params = array (
				'listid' => $listid,
				'emailaddress' => $emailaddress,
				'profileid' => $profileid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
	     * IsUnsubscriberMobile
	     * Checks whether an mobile number is an 'unsubscriber' - they have
	     * unsubscribed from a list.
	     *
	     * @param Int listid
	     *        	List to check for.
	     * @param String mobileNumber
	     *        	Mobile number to check.
	     * @param String mobilePrefix
	     *        	Country calling code.
	     * @param Int profileid
	     *        	Profile id to check.
         *        	
	     */
	public function IsUnsubscriberMobile (int $listid = 0, string $mobileNumber = "", string $mobilePrefix = "", int $profileid = 0)
	{
		$url = $this->URL . '/Profiles/IsUnsubscriberMobile';
		
		$params = array (
				'listid' => $listid,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix,
				'profileid' => $profileid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
	     * GetLeadScore
	     * Get lead score for profile
	     *
         * @param Int profileid
         *           Id of profile
	     *
	     */
	public function GetLeadScore (int $profileid = 0)
	{
		$url = $this->URL . '/Profiles/GetLeadScore';
		
		$params = array (
				'profileid' => $profileid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
	     * SetLeadScore
	     * Set lead score to particular profile
	     *
         * @param Int profileid
         *           Id of profile
	     * @param Int leadScore
	     *        	New value for lead score
	     *.
	     */
	public function SetLeadScore (int $profileid = 0, int $leadScore = 0 )
	{
		$url = $this->URL . '/Profiles/SetLeadScore';
		
		$params = array (
				'profileid' => $profileid,
				'leadScore' => $leadScore
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
	     * AddLeadScore
	     * Add lead score to particular profile
	     *
         * @param Int profileid
         *           Id of profile
	     * @param Int leadScore
	     *        	Valud to add for lead score
	     *.
	     */
	public function AddLeadScore (int $profileid = 0, int $leadScore = 0 )
	{
		$url = $this->URL . '/Profiles/AddLeadScore';
		
		$params = array (
				'profileid' => $profileid,
				'leadScore' => $leadScore
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	/**
	     * ReduceLeadScore
	     * Reduce lead score to particular profile
	     *
         * @param Int profileid
         *           Id of profile
	     * @param Int leadScore
	     *        	Valud to reduce for lead score
	     *.
	     */
	public function ReduceLeadScore (int $profileid = 0, int $leadScore = 0 )
	{
		$url = $this->URL . '/Profiles/ReduceLeadScore';
		
		$params = array (
				'profileid' => $profileid,
				'leadScore' => $leadScore
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
	     * GetLists
	     * Calls up all the Lists that this user either owns or has access to.
	     *
	     * @param Int limit
	     * 			Number of records you want to fetch.
	     * @param Int offset
	     * 			From where to start.
	     */
	public function GetLists(int $limit = 10, int $offset = 0)
	{
		$url = $this->URL . '/Lists/GetLists';
		
		$params = array (
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	
	 /**
	     * CreateList
	     * This function creates a list based on the current class vars.
	     *
	     * @param String listName
	     * 			Name of the list.
	     * @param String descriptiveName
	     * 			List description.
	     * @param String mobilePrefix
	     * 			Default country calling code.
	     *
	     */
	public function CreateList(string $listName = "", string $descriptiveName = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Lists/CreateList';
		
		$params = array (
				'listName' => $listName,
				'descriptiveName' => $descriptiveName,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
	     * AddDataFieldsToList
	     * This function add contact fields to list.
	     *
	     * @param Int listid
	     * 			List ID of the list where to add contact fields.
	     * @param Array contactFields
	     * 			Which contact fields to add.
	     *
	     */
	public function AddDataFieldsToList(int $listid = 0, array $contactFields = array())
	{
		$url = $this->URL . '/Lists/AddDataFieldsToList';
		
		$params = array (
				'listid' => $listid,
				'contactFields' => $contactFields
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
	     * UpdateList
	     * Updates a current list based on the current class vars.
	 
	     * @param Int listid
	     * 			ID of list which you want to edit.
	     * @param String listName
	     * 			New name of the list.
	     * @param String descriptiveName
	     * 			New list description.
	     * @param String mobilePrefix
	     * 			New country calling code.
	     *
	     */
	public function UpdateList(int $listid = 0, string $listName = "", string $descriptiveName = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Lists/UpdateList';
		
		$params = array (
				'listid' => $listid,
				'listName' => $listName,
				'descriptiveName' => $descriptiveName,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
	     * CopyList
	     * Copy list details only along with custom field associations.
	     *
	     * @param Integer listid
	     *        	Listid to copy.
	     * @param String listName
	     * 			New name of the list.
	     * @param String descriptiveName
	     * 			New list description.
	     *
	     */
	public function CopyList(int $listid = 0, string $listName = "", string $descriptiveName = "")
	{
		$url = $this->URL . '/Lists/CopyList';
		
		$params = array (
				'listid' => $listid,
				'listName' => $listName,
				'descriptiveName' => $descriptiveName
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
	     * DeleteList
	     * Delete a list from the database.
	     *
	     * @param Int listid
	     *        	Listid of the list to delete. If not passed in, it will delete
	     *        	'this' list.
	     *
	     */
	public function DeleteList(int $listid = 0)
	{
		$url = $this->URL . '/Lists/DeleteList';
		
		$params = array (
				'listid' => $listid
		);

		return $this->MakeDeleteRequest($url, $params);
	}
	
	/**
	     * CreateDataField
	     * Create new data field
	     *
	     * @param string $name name of custom field.
	     * @param object fieldType object of field type.
	     *
	     */
	public function CreateDataField(string $fieldName = '', string $fieldType = '', array $fieldSettings = array())
	{
		$url = $this->URL . '/DataFields/CreateDataField';

		$params = array (
				'fieldName' => $fieldName,
				'fieldType' => $fieldType,
				'fieldSettings' => $fieldSettings
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
	     * LoadDataField
	     * Loads up the data field
         * 
	     * @param Int fieldid
	     *        	The fieldid to load up. If the field is not present then it
	     *        	will not load up.
	     * @param Boolean loadLists
	     *        	Whether to load lists or not
	     *
	     */
	public function LoadDataField (int $fieldid = 0, bool $loadLists = false)
	{
		$url = $this->URL . "/DataFields/LoadDataField";
		
		$params = array (
				'fieldid' => $fieldid,
				'loadLists' => $loadLists
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetDataFields
        * Loads up the data fields for particular list
        * 
        * @param Int listid
        *        	The listid for which to load the data fields.
        * @param String fieldType
        *        	Field type to load.
        * @param Int limit
	    * 			Number of records you want to fetch.
	    * @param Int offset
	    * 			From where to start.        	
        *
        */
	public function GetDataFields(int $listid = 0, string $fieldType = "", int $limit = 10, int $offset = 0)
	{
		$url = $this->URL . '/Lists/GetDataFields';
		
		$params = array (
				'listid' => $listid,
				'fieldType' => $fieldType,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
          * GetSampleDataForOTM
          * Get sample data for otm field.
          * 
          * @param Int fieldid
          *        	The otm field id.
          *
          */
	public function GetSampleDataForOTM(int $fieldid = 0)
	{
		$url = $this->URL . '/DataFields/GetSampleDataForOTM';
		
		$params = array (
				'fieldid' => $fieldid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfileTrackingEvents
           * Get tracking events for profile
           * 
           * @param Int profileid
           *           Id of the profile
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfileTrackingEvents(int $profileid = 0, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileTrackingEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfilesUpdatedDFSince
           * Get profiles which is data fields is updated from particular date
           * 
           * @param Int listid
           *           Id of the list
           * @param String date
           *           Date from where to search
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfilesUpdatedDFSince(int $listid = 0, string $date = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesUpdatedDFSince';
		
		$params = array (
				'listid' => $listid,
				'date' => $date,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfilesUnsubscribedSince
           * Get profiles which is unsubscribed from particular date
           * 
           * @param Int listid
           *           Id of the list
           * @param String date
           *           Date from where to search
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfilesUnsubscribedSince(int $listid = 0, string $date = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesUnsubscribedSince';
		
		$params = array (
				'listid' => $listid,
				'date' => $date,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfilesConfirmedSince
           * Get profiles which is confirmed from particular date
           * 
           * @param Int listid
           *           Id of the list
           * @param String date
           *           Date from where to search
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfilesConfirmedSince(int $listid = 0, string $date = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesConfirmedSince';
		
		$params = array (
				'listid' => $listid,
				'date' => $date,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfilesDisabledSince
           * Get profiles which is disabled from particular date
           * 
           * @param Int listid
           *           Id of the list
           * @param String date
           *           Date from where to search
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfilesDisabledSince(int $listid = 0, string $date = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesDisabledSince';
		
		$params = array (
				'listid' => $listid,
				'date' => $date,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetProfilesSMSUnsubscribedSince
           * Get profiles which is sms unsubscribed from particular date
           * 
           * @param Int listid
           *           Id of the list
           * @param String date
           *           Date from where to search
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfilesSMSUnsubscribedSince (int $listid = 0, string $date = "", int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesSMSUnsubscribedSince';
		
		$params = array (
				'listid' => $listid,
				'date' => $date,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * Getriggers
           * Get all triggers
           * 
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetTriggers(int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Triggers/GetTriggers';
		
		$params = array (
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * GetriggersForSegment
          * Get all triggers for particular segment
          * 
          * @param Int segmentid
          *           Id of the segment
          * @param Int limit
          * 		   Number of records you want to fetch.
          * @param Int offset
          * 		   From where to start.     	
          *
          */
	public function GetTriggersForSegment(int $segmentid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Segments/GetTriggersForSegment';
		
		$params = array (
				'segmentid' => $segmentid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfilesFromSegment
        * Get all profiles from particular segment
        *
        * @param Int segmentid
        *          Id of segment
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Boolean activeOnly
        *           Whether to get only active profiles or not
        * @param Int limit
        * 			Number of records you want to fetch.
        * @param Int offset
        * 			From where to start.       
        *
        */
	public function GetProfilesFromSegment(int $segmentid = 0, bool $countOnly = false, bool $activeOnly = true, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfilesFromSegment';
		
		$params = array (
				'segmentid' => $segmentid,
				'countOnly' => $countOnly,
				'activeOnly' => $activeOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
         * CreateSegment
         * Create new segment
         * 
         * @param String name
         *           Name of the segment
         * @param Dictionary rules
         * 		   Rules for new segment
         * @param String connector
         * 		   Connector for segment and/or  	
         *
         */
	public function CreateSegment(string $name = "", array $rules = array(), string $connector = 'and')
	{
		$url = $this->URL . '/Segments/CreateSegment';
		
		$params = array (
				'name' => $name,
				'rules' => $rules,
				'connector' => $connector
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
         * GetSegments
         * Get all segments for particular list
         * 
         * @param Int list
         *           Id of the list
         * @param Int limit
         * 		   Number of records you want to fetch.
         * @param Int offset
         * 		   From where to start.     	
         *
         */
	public function GetSegments(int $listid = 0, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Segments/GetSegments';
		
		$params = array (
				'listid' => $listid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
	     * ChangeMobile
	     * Change mobile number for profile
	     *
	     *
	     * @param Integer profileid
	     * 			Profile id to update.
	     * @param String mobileNumber
	     * 			New mobile number
	     * @param String mobilePrefix
	     * 			New country dialing code
	     *
	     */
	public function ChangeMobile(int $profileid = 0, string $mobileNumber = '', string $mobilePrefix = '')
	{
		$url = $this->URL . '/Profiles/ChangeMobile';
		
		$params = array (
				'profileid' => $profileid,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
         * GetRulesForSegment
         * Get rules for particular segment
         * 
         * @param Int segmentid
         *           Id of the segment     	
         *
         */
	public function GetRulesForSegment(int $segmentid = 0)
	{
		$url = $this->URL . '/Segments/GetRulesForSegment';
		
		$params = array (
				'segmentid' => $segmentid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetAllListsForEmailAddress
        * Get all lists for particular email
        *
        * @param String emailaddress
        *        	Email address which looking for
        *        	
        */
	public function GetAllListsForEmailAddress (string $emailaddress = "")
	{
		$url = $this->URL . '/Profiles/GetAllListsForEmailAddress';
		
		$params = array (
				'emailaddress' => $emailaddress
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetAllListsForMobileNumber
        * Get all lists for particular mobile
        *
        * @param String mobileNumber
        *        	Mobile number which is looking for
        * @param String mobilePrefix
        *        	Country calling code
        *        	
        */
	public function GetAllListsForMobileNumber (string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/Profiles/GetAllListsForMobileNumber';
		
		$params = array (
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * FetchStats
          * Get all stats by stat id and type
          * 
          * @param Int statid
          *            Statid which looking for
          * @param String statsType
          * 		   Type of stats which looking for
          *
          */
	public function FetchStats(int $statid = 0, string $statsType = "")
	{
		$url = $this->URL . '/Stats/FetchStats';
		// if($params['statid'] && $params['statsType'])
		// {
		$params = array (
				'statid' => $statid,
				'statsType' => $statsType
		);
		
		$params = json_encode($params);
		return $this->MakeGetRequest($url, $params);
		// }
		// return self::REQUEST_FAILED;
	}
	
	 /**
          * FetchStatsNewsletter
          * Get stats for newsletters by stat id and type
          * 
          * @param Int statid
          *            Statid which looking for
          *
          */
	public function FetchStatsNewsletter(int $statid = 0)
	{
		$url = $this->URL . '/Stats/FetchStatsNewsletter';
		
		$params = array (
				'statid' => $statid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * FetchStatsAutoresponder
          * Get stats for autoresponder by stat id and type
          * 
          * @param Int statid
          *            Statid which looking for
          *
          */
	public function FetchStatsAutoresponder(int $statid = 0)
	{
		$url = $this->URL . '/Stats/FetchStatsAutoresponder';
		
		$params = array (
				'statid' => $statid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * FetchStatsSMS
          * Get stats for sms by stat id and type
          * 
          * @param Int statid
          *            Statid which looking for
          *
          */
	public function FetchStatsSMS(int $statid = 0)
	{
		$url = $this->URL . '/Stats/FetchStatsSMS';
		
		$params = array (
				'statid' => $statid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
         * GetStatidsByList
         * Get all stats for particular list
         * 
         * @param Int listid
         *           Id of the list
         * @param String fromDate
         *           From date to looking for
         * @param String toDate
         *           To date to looking for
         * @param Int limit
         * 		   Number of records you want to fetch.
         * @param Int offset
         * 		   From where to start.     	
         *
         */
	public function GetStatidsByList(int $listid = 0, string $fromDate = "", string $toDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetStatidsByList';
		
		$params = array (
				'listid' => $listid,
				'fromDate' => $fromDate,
				'toDate' => $toDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetStatidsBySegment
        * Get all stats for particular segment
        * 
        * @param Int segmentid
        *           Id of the segment
        * @param String fromDate
        *           From date to looking for
        * @param String toDate
        *           To date to looking for
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetStatidsBySegment(int $segmentid = 0, string $fromDate = "", string $toDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetStatidsBySegment';
		
		$params = array (
				'segmentid' => $segmentid,
				'fromDate' => $fromDate,
				'toDate' => $toDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetStatidsByNewsletter
        * Get all stats for particular newsletter
        * 
        * @param Int newsletterid
        *           Id of the newsletter
        * @param String fromDate
        *           From date to looking for
        * @param String toDate
        *           To date to looking for
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetStatidsByNewsletter(int $newsletterid = 0, string $fromDate = "", string $toDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetStatidsByNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'fromDate' => $fromDate,
				'toDate' => $toDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetStatidsByAutoresponder
        * Get all stats for particular autoresponder
        * 
        * @param Int newsletterid
        *           Id of the autoresponderid
        * @param String fromDate
        *           From date to looking for
        * @param String toDate
        *           To date to looking for
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetStatidsByAutoresponder(int $autoresponderid = 0, string $fromDate = "", string $toDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetStatidsByAutoresponder';
		
		$params = array (
				'autoresponderid' => $autoresponderid,
				'fromDate' => $fromDate,
				'toDate' => $toDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
	     * GetBouncesByList
	     * Fetches a list of bounced emails.
	     *
	     * @param Integer listid
	     *        	Id of a list from which the results are fetched.
	     * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
	     * @param String bounceType
	     * 			The type of bounce to get results for ("soft","hard","any").
	     * @param String searchType
	     *			Which search rule should be used in date search.
	     *			Possible values: before, after, between, not, exact/exactly.
	     * @param String searchStartDate
	     * 			Date for filtering.
	     * @param String searchEndDate
	     * 			Date for filtering.
         * @param Int limit
         *          Number of records you want to fetch.
         * @param Int offset
         * 		    From where to start.
	     *
	     */
	public function GetBouncesByList(int $listid = 0, bool $countOnly = false, string $bounceType = "", string $searchType = "",
	                                 string $searchStartDate = "", string $searchEndDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetBouncesByList';
		
		$params = array (
				'listid' => $listid,
				'countOnly' => $countOnly,
				'bounceType' => $bounceType,
				'searchType' => $searchType,
				'searchStartDate' => $searchStartDate,
				'searchEndDate' => $searchEndDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
	     * GetUnsubscribesByList
	     * Fetches a list of unsubscribed emails.
	     *
	     * @param Int listid
	     *        	Id of a list from which the results are fetched.
	     * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
	     * @param String searchType
	     *			Which search rule should be used in date search.
	     *			Possible values: before, after, between, not, exact/exactly.
	     * @param String searchStartDate
	     * 			Date for filtering.
	     * @param String searchEndDate
	     * 			Date for filtering.
         * @param Int limit
         *          Number of records you want to fetch.
         * @param Int offset
         * 		    From where to start.
	     *
	     */
	public function GetUnsubscribesByList(int $listid = 0, bool $countOnly = false, string $searchType = "", string $searchStartDate = "", 
	                                      string $searchEndDate = "", int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetUnsubscribesByList';
		
		$params = array (
				'listid' => $listid,
				'countOnly' => $countOnly,
				'searchType' => $searchType,
				'searchStartDate' => $searchStartDate,
				'searchEndDate' => $searchEndDate,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
	     * GetOpens
	     * Fetches a list of PROFILES who opened a campaign or autoresponder.
	     *
	     * @param Int statid
	     *        	The statids you want to fetch data for.
	     * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
	     * @param Int onlyUnique
	     *        	Specify true to count/retrieve unique opens only, specify
	     *        	false for all opens.
         * @param Int limit
         *          Number of records you want to fetch.
         * @param Int offset
         * 		    From where to start.
	     *
	     */
	public function GetOpens(int $statid = 0, bool $countOnly = false, bool $onlyUnique = false, int $limit = 100, int $offset = 0)
	{
	    $url = $this->URL . '/Stats/GetOpens';
// 	    if($params['statid'])
// 	    {
	        $params = array (
	            'statid' => $statid,
	            'countOnly' => $countOnly,
	            'onlyUnique' => $onlyUnique,
	            'limit' => $limit,
	            'offset' => $offset
	        );
	        
// 	        $params = json_encode($params);
	        return $this->MakeGetRequest($url, $params);
// 	    }
// 	    return self::REQUEST_FAILED;
	}
	
	/**
	     * GetClicks
	     * Fetches a list of profiles who clicked a campaign or autoresponder.
	     *
	     * @param Int statid
	     *        	The statids you want to fetch data for.
	     * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
	     * @param Int onlyUnique
	     *        	Specify true to count/retrieve unique opens only, specify
	     *        	false for all opens.
         * @param Int limit
         *          Number of records you want to fetch.
         * @param Int offset
         * 		    From where to start.
	     *
	     */
	public function GetClicks(int $statid = 0, bool $countOnly = false, bool $onlyUnique = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetClicks';
		
		$params = array (
				'statid' => $statid,
				'countOnly' => $countOnly,
				'onlyUnique' => $onlyUnique,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetRecipientsForAutoresponderByStatid
        * Get profiles for autoresponder for particular stat id
        *
        * @param Int statid
        *        	Stat id
        * @param Boolean countOnly
        *           If specify true will return only number of how many records
        *           If specify false will return array of all records
        * @param Int limit
        *          Number of records you want to fetch.
        * @param Int offset
        * 		    From where to start.
        *
        */
	public function GetRecipientsForAutoresponderByStatid(int $statid = 0, bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Stats/GetRecipientsForAutoresponderByStatid';
		
		$params = array (
				'statid' => $statid,
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * SetTriggerStatus
           * Change status for trigger
           *
           * @param Int triggerid
           *          Id of trigger
           * @param Bollean status
           *         New status for trigger
           *
           */
	public function SetTriggerStatus(int $triggerid = 0, bool $status = false)
	{
		$url = $this->URL . '/Triggers/SetTriggerStatus';
		
		$params = array (
				'triggerid' => $triggerid,
				'status' => $status
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
          * SetAutoresponderStatus
          * Change status for autoresponder
          *
          * @param Int autoresponderid
          *        	Id of autoresponder
          * @param Boolean status
          *        	New status for autoresponder
          *
          */
	public function SetAutoresponderStatus(int $autoresponderid = 0, bool $status = false)
	{
		$url = $this->URL . '/Autoresponders/SetAutoresponderStatus';
		
		$params = array (
				'autoresponderid' => $autoresponderid,
				'status' => $status
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
          * ScheduleSendNewsletter
          * Schedule newsletter campaign for sending.
          *
          * @param Int newsletterid
          *        	ID of the campaign which need to be scheduled.
          * @param Float timeToSend
          * 			When should the campaign start
          * 			(In how many hours from a starting point(real time : now))
          * @param Boolean saveSnapshots
          * 			Whetner to save snapshot or not
          * @param Boolean reloadFeed
          * 			Whetner to reload feed or not
          * @param Boolean notifyOwner
          * 			Whetner to send notification to owner or not
          * 
          */
	public function ScheduleSendNewsletter(int $newsletterid = 0, float $timeToSend = 0, bool $saveSnapshots = false, bool $reloadFeed = true, $notifyOwner = false)
	{
		$url = $this->URL . '/Sends/ScheduleSendNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'timeToSend' => $timeToSend,
				'saveSnapshots' => $saveSnapshots,
				'reloadFeed' => $reloadFeed,
				'notifyOwner' => $notifyOwner
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
         * ScheduleSendNewsletterToList
         * Schedule newsletter campaign for sending to particular list
         *
         * @param Int newsletterid
         *        	ID of the campaign which need to be scheduled.
         * @param Int listid
         *        	ID of the list	
         * @param Float timeToSend
         * 			When should the campaign start
         * 			(In how many hours from a starting point(real time : now))
         * @param Boolean saveSnapshots
         * 			Whetner to save snapshot or not
         * @param Boolean reloadFeed
         * 			Whetner to reload feed or not
         * @param Boolean notifyOwner
         * 			Whetner to send notification to owner or not
         * 
         */
	public function ScheduleSendNewsletterToList(int $newsletterid = 0, int $listid = 0, float $timeToSend = 0, bool $saveSnapshots = false, bool $reloadFeed = true, $notifyOwner = false)
	{
		$url = $this->URL . '/Sends/ScheduleSendNewsletterToList';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'listid' => $listid,
				'timeToSend' => $timeToSend,
				'saveSnapshots' => $saveSnapshots,
				'reloadFeed' => $reloadFeed,
				'notifyOwner' => $notifyOwner
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
         * ScheduleSendNewsletterToSegment
         * Schedule newsletter campaign for sending to particular segment
         *
         * @param Int newsletterid
         *        	ID of the campaign which need to be scheduled.
         * @param Int segmentid
         *        	ID of the segment	
         * @param Float timeToSend
         * 			When should the campaign start
         * 			(In how many hours from a starting point(real time : now))
         * @param Boolean saveSnapshots
         * 			Whetner to save snapshot or not
         * @param Boolean reloadFeed
         * 			Whetner to reload feed or not
         * @param Boolean notifyOwner
         * 			Whetner to send notification to owner or not
         * 
         */
	public function ScheduleSendNewsletterToSegment(int $newsletterid = 0, int $segmentid = 0, float $timeToSend = 0, bool $saveSnapshots = false, bool $reloadFeed = true, $notifyOwner = false)
	{
		$url = $this->URL . '/Sends/ScheduleSendNewsletterToSegment';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'segmentid' => $segmentid,
				'timeToSend' => $timeToSend,
				'saveSnapshots' => $saveSnapshots,
				'reloadFeed' => $reloadFeed,
				'notifyOwner' => $notifyOwner
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
         * ScheduleSendSMS
         * Schedule sms campaign for sending
         *
         * @param Int newsletterid
         *        	ID of the campaign which need to be scheduled.
         * @param Int listid
         *        	ID of the list	
         *  @param Int segmentid
         *        	ID of the segment
         * @param Float timeToSend
         * 			When should the campaign start
         * 			(In how many hours from a starting point(real time : now))
         * 
         */
	public function ScheduleSendSMS(int $newsletterid = 0, int $listid = 0, int $segmentid = 0, float $timeToSend = 0)
	{
		$url = $this->URL . '/SMSSends/ScheduleSendSMS';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'listid' => $listid,
				'segmentid' => $segmentid,
				'timeToSend' => $timeToSend
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	/**
        * SendNewsletter
        * Send newsletter to particular profile
        *
        * @param Int newsletterid
        *        	ID of the campaign which need to be scheduled.
        * @param Int profileid
        *        	ID of the profile 	
        * @param String emailaddress
        * 			Email address of profile
        * @param String callbackUrl
        * 			Url to be notifed after sending to see status 
        * @param Boolean notifyOwner
        * 			Whetner to send notification to owner or not
        * 
        */
	public function SendNewsletter(int $newsletterid = 0, int $profileid = 0, string $emailaddress = "", string $callbackUrl = "", $notifyOwner = false)
	{
		$url = $this->URL . '/Messaging/SendNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'profileid' => $profileid,
				'emailaddress' => $emailaddress,
				'callbackUrl' => $callbackUrl,
				'notifyOwner' => $notifyOwner
		);
		
		return $this->MakePostRequest($url, $params);
	}
	 /**
        * SendSMS
        * Send sms to particular profile
        *
        * @param Int campaignid
        *        	ID of the campaign which need to be scheduled.
        * @param Int profileid
        *        	ID of the profile 	
        * @param Int listid
        * 			Id of the list
        * @param String mobileNumber
        * 			Mobile number of profile
        * @param Boolean mobilePrefix
        * 			Country dialling code
        * 
        */
	public function SendSMS(int $campaignid = 0, int $profileid = 0, int $listid = 0, string $mobileNumber = "", string $mobilePrefix = "")
	{
		$url = $this->URL . '/SMS/SendSMS';
		
		$params = array (
				'campaignid' => $campaignid,
				'profileid' => $profileid,
				'listid' => $listid,
				'mobileNumber' => $mobileNumber,
				'mobilePrefix' => $mobilePrefix
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
	     * GetNewsletters
	     * Fetches a list of profiles who opened a campaign or autoresponder.
	     *
	     * @param Boolean countOnly
         *           If specify true will return only number of how many records
         *           If specify false will return array of all records
         * @param Int limit
         *          Number of records you want to fetch.
         * @param Int offset
         * 		    From where to start.
	     *
	     */
	public function GetNewsletters(bool $countOnly = false, int $limit = 100, int $offset = 0)
	{
		$url = $this->URL . '/Newsletters/GetNewsletters';
		
		$params = array (
				'countOnly' => $countOnly,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
	     * GetNewsletterLatestStats
	     * Get latest stats for particular newsletter
	     *
         * @param Int newsletterid
         *          Id of newsletter
	     *
	     */
	public function GetNewsletterLatestStats(int $newsletterid = 0)
	{
		$url = $this->URL . '/Stats/GetNewsletterLatestStats';
		
		$params = array (
				'newsletterid' => $newsletterid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * ViewNewsletter
        * View particular newsletter
        *
        * @param Int newsletterid
        *          Id of newsletter
        *
        */
	public function ViewNewsletter(int $newsletterid = 0)
	{
		$url = $this->URL . '/Newsletters/ViewNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * EditNewsletter
           * Upadte particular newsletter
           *
           * @param Int newsletterid
           *          Id of newsletter
           * @param String newsletterName
           *          New name for newsletter
           * @param String newsletterSubject
           *          New subject for newsletter
           *
           *
           */
	public function EditNewsletter(int $newsletterid = 0, string $newsletterName = "", string $newsletterSubject = "")
	{
		$url = $this->URL . '/Newsletters/EditNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'newsletterName' => $newsletterName,
				'newsletterSubject' => $newsletterSubject
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
          * CopyNewsletter
          * Make a copy of particular newsletter
          *
          * @param Int newsletterid
          *          Id of newsletter
          * @param String newsletterName
          *          New name for newsletter
          * @param String newsletterSubject
          *          New subject for newsletter
          *
          *
          */
	public function CopyNewsletter(int $newsletterid = 0, string $newsletterName = "", string $newsletterSubject = "")
	{
		$url = $this->URL . '/Newsletters/CopyNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'newsletterName' => $newsletterName,
				'newsletterSubject' => $newsletterSubject
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
       * GetProfileSentNewsletterEvents
       * Get sent newsletter events for profile
       * 
       * @param Int profileid
       *           Id of the profile
       * @param Int limit
       * 		   Number of records you want to fetch.
       * @param Int offset
       * 		   From where to start.     	
       *
       */
	public function GetProfileSentNewsletterEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileSentNewsletterEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
      * GetProfileOpenNewsletterEvents
      * Get open newsletter events for profile
      * 
      * @param Int profileid
      *           Id of the profile
      * @param Int limit
      * 		   Number of records you want to fetch.
      * @param Int offset
      * 		   From where to start.     	
      *
      */
	public function GetProfileOpenNewsletterEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileOpenNewsletterEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
         * GetProfileClickNewsletterEvents
         * Get clicked newsletter events for profile
         * 
         * @param Int profileid
         *           Id of the profile
         * @param Int limit
         * 		   Number of records you want to fetch.
         * @param Int offset
         * 		   From where to start.     	
         *
         */
	public function GetProfileClickNewsletterEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileClickNewsletterEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfileSentTriggerEvents
        * Get sent trigger events for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetProfileSentTriggerEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileSentTriggerEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfileOpenTriggerEvents
        * Get open trigger events for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetProfileOpenTriggerEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileOpenTriggerEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfileClickTriggerEvents
        * Get clicked trigger events for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetProfileClickTriggerEvents(int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileClickTriggerEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
        * GetProfileSentAutoresponderEvents
        * Get sent autoresponder events for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetProfileSentAutoresponderEvents (int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileSentAutoresponderEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
        * GetProfileOpenAutoresponderEvents
        * Get open autoresponder events for profile
        * 
        * @param Int profileid
        *           Id of the profile
        * @param Int limit
        * 		   Number of records you want to fetch.
        * @param Int offset
        * 		   From where to start.     	
        *
        */
	public function GetProfileOpenAutoresponderEvents (int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileOpenAutoresponderEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
           * GetProfileClickAutoresponderEvents
           * Get clicked autoresponder events for profile
           * 
           * @param Int profileid
           *           Id of the profile
           * @param Int limit
           * 		   Number of records you want to fetch.
           * @param Int offset
           * 		   From where to start.     	
           *
           */
	public function GetProfileClickAutoresponderEvents (int $profileid = 0, int $limit = 100, $offset = 0)
	{
		$url = $this->URL . '/Profiles/GetProfileClickAutoresponderEvents';
		
		$params = array (
				'profileid' => $profileid,
				'limit' => $limit,
				'offset' => $offset
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetTriggerSummary
           * Get summary for particular trigger
           *
           * @param Int triggerid
           *          Id of trigger
           * @param String fromDate
           *         Date from
           * @param String toDate
           *         Date to
           *
           */
	public function GetTriggerSummary (int $triggerid = 0, string $fromDate = "", string $toDate = "")
	{
		$url = $this->URL . '/Stats/GetTriggerSummary';
		
		$params = array (
				'triggerid' => $triggerid,
				'fromDate' => $fromDate,
				'toDate' => $toDate
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetAutoresponderSummary
           * Get summary for particular autoresponder
           *
           * @param Int autoresponderid
           *          Id of autoresponder
           * @param String fromDate
           *         Date from
           * @param String toDate
           *         Date to
           *
           */
	public function GetAutoresponderSummary (int $autoresponderid = 0, string $fromDate = "", string $toDate = "")
	{
		$url = $this->URL . '/Stats/GetAutoresponderSummary';
		
		$params = array (
				'autoresponderid' => $autoresponderid,
				'fromDate' => $fromDate,
				'toDate' => $toDate
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	  /**
         * GetNewsletterSummary
         * Get summary for particular newsletter
         *
         * @param Int newsletterid
         *          Id of newsletter
         * @param String fromDate
         *         Date from
         * @param String toDate
         *         Date to
         *
         */
	public function GetNewsletterSummary (int $newsletterid = 0, string $fromDate = "", string $toDate = "")
	{
		$url = $this->URL . '/Stats/GetNewsletterSummary';
		
		$params = array (
				'newsletterid' => $newsletterid,
				'fromDate' => $fromDate,
				'toDate' => $toDate
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
		 /**
          * GetSegmentSummary
          * Get summary for particular segment
          *
          * @param Int segmentid
          *          Id of segment
          * @param String fromDate
          *         Date from
          * @param String toDate
          *         Date to
          *
          */
	public function GetSegmentSummary (int $segmentid = 0, string $fromDate = "", string $toDate = "")
	{
		$url = $this->URL . '/Stats/GetSegmentSummary';
		
		$params = array (
				'segmentid' => $segmentid,
				'fromDate' => $fromDate,
				'toDate' => $toDate
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
           * GetListSummary
           * Get summary for particular list
           *
           * @param Int listid
           *          Id of list
           * @param String fromDate
           *         Date from
           * @param String toDate
           *         Date to
           *
           */
	public function GetListSummary (int $listid = 0, string $fromDate = "", string $toDate = "")
	{
		$url = $this->URL . '/Stats/GetListSummary';
		
		$params = array (
				'listid' => $listid,
				'fromDate' => $fromDate,
				'toDate' => $toDate
		);
		
		return $this->MakeGetRequest($url, $params);
	}
	
	 /**
           * DeleteDataField
           * Delete data field
           * 
           * @param Int fieldid
           *        	The fieldid to delete.
           *
           */
	public function DeleteDataField (int $fieldid = 0)
	{
		$url = $this->URL . '/DataFields/DeleteDataField';
		
		$params = array (
				'fieldid' => $fieldid
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
	/**
        * DeleteSegment
        * Delete particular segment
        *
        * @param Int segmentid
        *          Id of segment       
        *
        */
	public function DeleteSegment(int $segmentid = 0)
	{
		$url = $this->URL . '/Segments/DeleteSegment';
		
		$params = array (
				'segmentid' => $segmentid
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
	 /**
           * DeleteTrigger
           * Delete particular trigger
           *
           * @param Int triggerid
           *          Id of trigger       
           *
           */
	public function DeleteTrigger(int $triggerid = 0)
	{
		$url = $this->URL . '/Triggers/DeleteTrigger';
		
		$params = array (
				'triggerid' => $triggerid
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
	 /**
        * DeleteNewsletter
        * Delete particular newsletter
        *
        * @param Int newsletterid
        *          Id of newsletter
        *
        */
	public function DeleteNewsletter (int $newsletterid = 0)
	{
		$url = $this->URL . '/Newsletters/DeleteNewsletter';
		
		$params = array (
				'newsletterid' => $newsletterid
		);
		
		return $this->MakeDeleteRequest($url, $params);
	}
	
	 /**
           * ReloadFeed
           * Reload particular feed
           *
           * @param Int feedURL
           *         Url of feed       
           *
           */
	public function ReloadFeed(string $feedURL = '')
	{
		$url = $this->URL . '/Sends/ReloadFeed';
		
		if($feedURL)
		{
			$params = array (
					'feedURL' => $feedURL
			);
			
			$params = json_encode($params);
			return $this->MakePostRequest($url, $params);
		}
		
		return self::REQUEST_FAILED;
	}
	
	 /**
        * ImportContacts
        * Import contacts to particular list 
        *
        * @param Int listid
        *          Id of list
        * @param Dictionary request
        *           Request for import
        * @param Dictionary keys
        *           Keys for import
        * @param String callbackURL
        * 			URL for notify status when import will done    
        *
        */
	public function ImportContacts(int $listid = 0, array $request = array(), array $keys = array(), string $callbackURL = '')
	{
		$url = $this->URL . '/Profiles/ImportContacts';
		
		$params = array (
			'listid' => $listid,
			'request' => $request,
			'keys' => $keys,
			'callbackURL' => $callbackURL
		);
	
		$params = json_encode($params);
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
           * GetImportStatus
           * Get status for particular import
           *
           * @param Int importid
           *          Id of import       
           *
           */
	public function GetImportStatus(int $importid = 0)
	{
		$url = $this->URL . '/Profiles/GetImportStatus';
		
		$params = array (
				'importid' => $importid
		);
		
		$params = json_encode($params);
		return $this->MakeGetRequest($url, $params);
	}
	
	/**
          * CreateSubAccount
          * Create sub account by particular account 
          *
          * @param String accountName
          *          Name of account
          * @param String importid
          *          Password of account
          * @param String importid
          *          Email address
          * @param Array allowedDomains
          *          All allowed domains
          *
          */
	public function CreateSubAccount(string $accountName = "", string $accountPassword = "", string $ownerEmail = "", array $allowedDomains = array())
	{
		$url = $this->URL . '/Users/CreateSubAccount';
		
		$params = array (
				'accountName' => $accountName,
				'accountPassword' => $accountPassword,
				'ownerEmail' => $ownerEmail,
				'allowedDomains' => $allowedDomains
		);
		
		return $this->MakePostRequest($url, $params);
	}
	
	 /**
          * InheritListsToSubAccount
          * Inherit lists from particular account
          *
          * @param String accountName
          *          Name of account
          * @param Array inheritLists
          *          All lists for inherit
          *
          */
	public function InheritListsToSubAccount(string $accountName = "", array $inheritLists = array())
	{
		$url = $this->URL . '/Users/InheritListsToSubAccount';
		
		$params = array (
				'accountName' => $accountName,
				'inheritLists' => $inheritLists
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
          * InheritSegmentsToSubAccount
          * Inherit segments from particular account
          *
          * @param String accountName
          *          Name of account
          * @param Array inheritSegments
          *          All segments for inherit
          *
          */
	public function InheritSegmentsToSubAccount(string $accountName = "", array $inheritSegments = array())
	{
		$url = $this->URL . '/Users/InheritSegmentsToSubAccount';
		
		$params = array (
				'accountName' => $accountName,
				'inheritSegments' => $inheritSegments
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	 /**
         * InheritNewslettersToSubAccount
         * Inherit newsletters from particular account
         *
         * @param String accountName
         *          Name of account
         * @param int newsletterid
         *          Newsletter id for inherit
         * @param string linkType
         *          Type of link (segment,list)
         * @param array linkid
         *          Array of segments or lists according to linkType
         *
         */
	public function InheritNewsletterToSubAccount(string $accountName = "", int $newsletterid = 0, string $linkType = "", array $linkid = array())
	{
		$url = $this->URL . '/Users/InheritNewsletterToSubAccount';
		
		$params = array (
				'accountName' => $accountName,
				'newsletterid' => $newsletterid,
				'linkType' => $linkType,
				'linkid' => $linkid
		);
		
		return $this->MakePutRequest($url, $params);
	}
	
	
	
}
