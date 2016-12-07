<?php


/**
 * Authen controller
 */
class AuthenAPIController extends BaseController {

//    protected $requireAuth = false;

    protected $redirectGLG = 'https://auth.gluegent.net/saml/saml2/idp/SSOService.php?tenant=';
    protected $logoutLink = 'https://auth.gluegent.net/saml/saml2/idp/initSLO.php?RelayState=/saml/logout.php&logout=';

    function __construct() {
        $this->requireAuth = false;
        parent::__construct();
    }

    /**
     * Function redirect when user not login.
     *
     * @method: get
     *
     * @return mixed
     */
    public function getRedirect()
    {
        return Redirect::to($this->redirectGLG);
    }

    /**
     * Function process auth when has response from GLG.
     *
     * @method: (any)  | get
     *
     * @return mixed
     */
    public function getCallback() {

        $request = Input::all();
        $loginID = !empty($request['id']) ? $request['id'] : null;

        if ($loginID) {

            $userInfo = DataManager::getUserInfo($loginID);

            if($userInfo ){

                $user = new ChirpUser($userInfo);
                Session::put('SESSION_KEY_CHIRP_USER', serialize($user));

                return Redirect::to('/top');

            }else{
                die("khong có tai khoan nay");
                return Redirect::to('/');

            }

        }

        return Redirect::to('/');

    }

    /**
     * Function throw exception or process on fail login ...
     *
     * @method: get
     *
     * @return: mixed
     */
    public function getFailure()
    {
        die("fail on cannot login!");
    }

    /**
     * Function redirect to logout.
     *
     * @method: get.
     *
     * @return mixed
     */
    public function getLogout()
    {
        $request = Input::all();
        $serviceId = !empty($request['serviceID']) ? $request['serviceID'] : null;

        return Redirect::to($this->logoutLink.$serviceId);

    }

}