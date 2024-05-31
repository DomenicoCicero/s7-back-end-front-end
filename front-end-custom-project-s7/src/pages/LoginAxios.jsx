import axios from "axios";
import { useState } from "react";
import { useDispatch } from "react-redux";
import { login } from "../redux/actions";

// per prima cosa installare axios con npm i axios

const LoginAxios = () => {
  const dispatch = useDispatch();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const updateInputValue = e => {
    console.log(e.target);
    setFormData(oldFormData => ({
      ...oldFormData,
      [e.target.name]: e.target.value,
    }));
  };

  const submitLogin = e => {
    e.preventDefault();
    console.log(formData);
    // recuperare il csrf token e il session token (che sono cookie)
    // per salvarli inserire un proxy in package.json e riavviare l'app => "proxy": "http://localhost:8000/"
    // gli indirizzi relativi, con il proxy attivo fanno la richiesta a http://localhost:8000/login mascherandolo come
    // indirizzo nello stesso host di react (che nel nostro caso è http://localhost:3000/login)

    // per fare una GET basta scrivere axios.get() passandogli l'api
    // per fare una POST basta fare axios.post() passandogli come primo argomento l'api e come secondo argomento l'api
    // farà automaticamente la conversione a json del body e non c'è più bisogno di inserire "Content-Type": "application/json"
    // come terzo argomento ci vanno le configurazioni, quindi un oggetto contenente gli header
    // ma possiamo fare in modo che axios li passi automaticamente aggiungendo due proprietà in App.js
    axios
      .get(`/sanctum/csrf-cookie`)
      .then(() => axios.post(`/login`, formData))
      .then(() => axios.get("/api/user"))
      .then(res => {
        dispatch(login(res.data));
      });
    // a differenza della fetch dove bisogna fare 2 then() per recuperare prima i dati della richiesta e poi i dati della risposta
    // axios ci torna tutto l'oggetto in un unico then() e i dati di risposta saranno sotto data
  };

  return (
    <form onSubmit={e => submitLogin(e)} noValidate>
      <div className="mb-3">
        <label htmlFor="email" className="form-label">
          Email address
        </label>
        <input
          type="email"
          className="form-control"
          id="email"
          name="email"
          onChange={e => updateInputValue(e)}
          value={formData.email}
        />
      </div>
      <div className="mb-3">
        <label htmlFor="password" className="form-label">
          Password
        </label>
        <input
          type="password"
          className="form-control"
          id="password"
          name="password"
          onChange={e => updateInputValue(e)}
          value={formData.password}
        />
      </div>
      {/* <div className="mb-3 form-check">
        <input type="checkbox" className="form-check-input" id="exampleCheck1" />
        <label className="form-check-label" htmlFor="exampleCheck1">
          Check me out
        </label>
      </div> */}
      <button type="submit" className="btn btn-primary">
        Login
      </button>
    </form>
  );
};

export default LoginAxios;
