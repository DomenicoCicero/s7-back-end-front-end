import { useSelector } from "react-redux";
import { Navigate, Outlet } from "react-router-dom";

const GuestRoutes = () => {
  const user = useSelector(state => {
    return state.user;
  });

  // componente Outlet va a vedere il contenuto e reinderizza il componente che fa match con la rotta
  // componente Navigate reinderizza nel percorso inserito
  return !user ? <Outlet /> : <Navigate to="/" />;
};

export default GuestRoutes;
