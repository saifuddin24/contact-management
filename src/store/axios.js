import axios from "axios";
const csrf_url = 'http://127.0.1:8000/sanctum/csrf-cookie';
const base_url = 'http://127.0.1:8000/api';

const LOGIN_TOKEN_KEY = '__login_token_key';
const USERDATA_TOKEN_KEY = '__userdata_token_key';

const set_token = ( token  ) => {
    if( token === false ) {
        localStorage.removeItem( LOGIN_TOKEN_KEY );
    } else {
        return localStorage.setItem( LOGIN_TOKEN_KEY, token );
    }
}

const get_user = (  ) => {
    const data= localStorage.getItem( USERDATA_TOKEN_KEY );
    if( data ) {
        return JSON.parse( data );
    }
    return null;
}

const set_user = ( user  ) => {
    if( user === false ) {
        localStorage.removeItem( USERDATA_TOKEN_KEY );
    } else {
        return localStorage.setItem( USERDATA_TOKEN_KEY, JSON.stringify( user ) );
    }
}

const isLoggedIn = ( ) => {
    const token = localStorage.getItem( LOGIN_TOKEN_KEY );
    return token ? true : false;
}

const get_token = ( ) => {
    return localStorage.getItem( LOGIN_TOKEN_KEY );
}

function getHeaders(){

    const headers = {
        ContentType     : 'Application/json',
        Accept          : 'Application/json'
    }

    const token = get_token();

    if( token ) {
        headers.Authorization = "Bearer " + token;
    }

    return headers;
}

async function set_csrf_cookie( ){
    return await axios.get( csrf_url, { withCredentials: true } );
}


export default ( options = { timeout : 10000, csrf: true } ) =>
{
    if( options.csrf ) {
        const csrf = set_csrf_cookie( );
    }

    return  axios.create({
        baseURL: base_url,
        timeout: options.timeout,
        headers: getHeaders( ),
        withCredentials: true
    });
};

export  { base_url, get_token, set_token, set_csrf_cookie, isLoggedIn, get_user, set_user }
