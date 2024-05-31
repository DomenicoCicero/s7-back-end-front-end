import axios from "axios";
import { useState } from "react";
import { useDispatch } from "react-redux";
import { login } from "../redux/actions";

const Register = () => {
  const dispatch = useDispatch();
  const [profileImage, setProfileImage] = useState(null);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    profile_img: "",
  });

  // in errors salviamo gli errori se andiamo a finire nel catch() della chiamata
  const [errors, setErrors] = useState(null);

  const updateInputValue = e => {
    setFormData(oldFormData => ({
      ...oldFormData,
      [e.target.name]: e.target.value,
    }));
  };

  const updateImageField = e => {
    updateInputValue(e);
    setProfileImage(e.target.files[0]);
  };

  const submitLogin = e => {
    e.preventDefault();
    axios
      .get(`/sanctum/csrf-cookie`)
      .then(() => {
        // instanziamo FormData per poter passare nel body della richiesta anche l'immagine
        // FormData è capace di contenere i dati binari di immagini, pdf, file, video ecc...
        // adesso all'oggetto body appendiamo anche gli altri campi che vanno passati
        const body = new FormData();
        body.append("name", formData.name);
        body.append("email", formData.email);
        body.append("password", formData.password);
        body.append("password_confirmation", formData.password_confirmation);
        body.append("profile_img", profileImage);

        return axios.post(`/register`, body);
      })
      .then(() => axios.get("/api/user"))
      .then(res => {
        dispatch(login(res.data));
      })
      .catch(err => {
        console.log(err.response.data.errors);
        setErrors(err.response.data.errors);
      });
  };

  return (
    <form onSubmit={e => submitLogin(e)} noValidate>
      <div className="mb-3">
        <label htmlFor="name" className="form-label">
          Name
        </label>
        <input
          type="text"
          className="form-control"
          id="name"
          name="name"
          onChange={e => updateInputValue(e)}
          value={formData.name}
        />
      </div>
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
      <div className="mb-3">
        <label htmlFor="password" className="form-label">
          Conferma Password
        </label>
        <input
          type="password"
          className="form-control"
          id="password_confirmation"
          name="password_confirmation"
          onChange={e => updateInputValue(e)}
          value={formData.password_confirmation}
        />
      </div>
      <div className="mb-3">
        <label htmlFor="profile_img" className="form-label">
          Profile Image
        </label>
        <input
          className="form-control"
          type="file"
          id="profile_img"
          name="profile_img"
          onChange={e => updateImageField(e)}
          value={formData.profile_img}
        />
      </div>
      <button type="submit" className="btn btn-primary">
        Register
      </button>
    </form>
  );
};

export default Register;
