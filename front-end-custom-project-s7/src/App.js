import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
import "./App.css";
import Home from "./pages/Home";
import FacultyPage from "./pages/FacultyPage";
import Register from "./pages/Register";
import LoginAxios from "./pages/LoginAxios";
import axios from "axios";
import TopNav from "./components/TopNav";
import "bootstrap/dist/css/bootstrap.min.css";
import { useEffect, useState } from "react";
import { useDispatch } from "react-redux";
import { login } from "./redux/actions";
import ProtectedRoutes from "./pages/ProtectedRoutes";
import GuestRoutes from "./pages/GuestRoutes";
import NotFound from "./pages/NotFound";
import Transcript from "./pages/Transcript";

function App() {
  // per far gestire automaticamente ad axios il passaggio degli header nella post
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;

  const dispatch = useDispatch();
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    axios
      .get("/api/user")
      .then(res => dispatch(login(res.data)))
      .catch(err => console.log(err))
      .finally(() => setLoaded(true));
  }, [dispatch]);

  return (
    loaded && (
      <BrowserRouter>
        <TopNav />
        <div className="container">
          {/* si possono creare rotte innestate per far in modo che alcune pagine siano accessibili solo se non si 
          è loggati ed altre solo se si è loggati, tutte le altre saranno accessibili indistintamente */}
          {/* creaiamo due Route passandogli i componenti che gestiranno la logica */}
          <Routes>
            {/* rotte accessibili da tutti */}
            <Route path="/" element={<Home />} />
            {/* rotte solo se sei loggato */}
            <Route element={<ProtectedRoutes />}>
              <Route path="/faculties/:id" element={<FacultyPage />} />
              <Route path="transcript" element={<Transcript />} />
            </Route>
            {/* rotte solo se NON sei loggato */}
            <Route element={<GuestRoutes />}>
              <Route path="/login" element={<LoginAxios />} />
              <Route path="/register" element={<Register />} />
            </Route>

            <Route path="404" element={<NotFound />} />
            <Route path="*" element={<Navigate to="/404" />} />
          </Routes>
        </div>
        {/* <MyFooter/> */}
      </BrowserRouter>
    )
  );
}

export default App;
