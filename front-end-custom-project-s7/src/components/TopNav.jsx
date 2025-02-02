import axios from "axios";
import { useDispatch, useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import { LOGOUT } from "../redux/actions";

const TopNav = () => {
  const user = useSelector(state => {
    return state.user;
  });

  const dispatch = useDispatch();
  const navigate = useNavigate();

  const logout = () => {
    // chiamiamo l'api che ci mette a disposizione laravel-breeze
    // questa chiamata disattiva lato server la sessione, praticamente cancella sul db la sessione
    // ed il cookie salvato nel browser non sarà più valido
    // axios passa automaticamente i cookie
    axios
      .post("/logout")
      .then(() => dispatch({ type: LOGOUT }))
      .then(() => navigate("/login"));
  };

  return (
    <nav className="navbar navbar-expand-lg bg-body-tertiary">
      <div className="container-fluid">
        <Link className="navbar-brand" to="/">
          App University
        </Link>
        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
        >
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <ul className="navbar-nav me-auto mb-2 mb-lg-0">
            <li className="nav-item">
              <Link className="nav-link active" to="/">
                Home
              </Link>
            </li>
            <li className="nav-item dropdown">
              <Link className="nav-link dropdown-toggle" to="/" data-bs-toggle="dropdown">
                Dropdown
              </Link>
              <ul className="dropdown-menu">
                <li>
                  <Link className="dropdown-item" to="/">
                    Action
                  </Link>
                </li>
                <li>
                  <hr className="dropdown-divider" />
                </li>
                <li>
                  <Link className="dropdown-item" to="/">
                    Something else here
                  </Link>
                </li>
              </ul>
            </li>
          </ul>
          {!user && (
            <>
              <Link className="btn btn-primary me-2" to="/login">
                Login
              </Link>
              <Link className="btn btn-primary" to="/register">
                Register
              </Link>
            </>
          )}

          {user && (
            <>
              <span className="me-2">{user.name}</span>
              {/* per accedere all'immagine adesso parto da storage/nomeImg */}
              <img src={`/storage/${user.profile_img}`} alt="" width={"50px"} />
              <button className="btn btn-primary" onClick={logout}>
                Logout
              </button>
            </>
          )}

          {/* <form className="d-flex" role="search">
            <input className="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
            <button className="btn btn-outline-success" type="submit">
              Search
            </button>
          </form> */}
        </div>
      </div>
    </nav>
  );
};

export default TopNav;
