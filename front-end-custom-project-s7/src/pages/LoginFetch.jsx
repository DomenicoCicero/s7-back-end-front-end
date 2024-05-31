import { useState } from "react";

const LoginFetch = () => {
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
    // fetch(`/sanctum/csrf-cookie`);
    // gli indirizzi relativi, con il proxy attivo fanno la richiesta a http://localhost:8000/login mascherandolo come
    // indirizzo nello stesso host di react (che nel nostro caso è http://localhost:3000/login)
    fetch(`/sanctum/csrf-cookie`)
      .then(() =>
        fetch(`/login`, {
          // fetch per mandare X-XSRF-TOKEN e valutare l'autenticità
          method: "POST",
          headers: {
            "Content-Type": "application/json", // serve a dire che quello che stiamo mandando è scritto in json
            Accept: "application/json", // serve a dire al server se puoi rispondimi in json
            "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
          },
          body: JSON.stringify(formData),
        })
      )
      .then(() => fetch("/api/user"))
      // fetch per recuperare i dati dell'utente chiamando l'api creata automaticamente da laravel
      // X-XSRF-TOKEN non va passato nelle richieste GET
      // le GET hanno bisogno solo della sessione, ma la sessione è un cookie e quindi il browser la invia automaticamente
      .then(res => res.json())
      .then(data => console.log(data));
    // ultimi 2 then per recuperare la risposta e stamparla
  };

  // funzione per recuperare il cookie
  // con document.cookie otteniamo una stringa con il nome del cookie ed il valore
  // ma a noi serve solo il valore e lo estrapoliamo con questa funzione
  const getCookie = cname => {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
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

export default LoginFetch;
