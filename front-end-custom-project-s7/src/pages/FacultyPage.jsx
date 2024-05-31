import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";

const FacultyPage = () => {
  const [faculty, setFaculty] = useState(null);
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetch(`/v1/faculties/${id}`)
      .then(res => {
        if (res.ok) {
          return res.json();
        } else {
          navigate("/404");
        }
      })
      .then(data => setFaculty(data))
      .catch(err => console.log(err));
  }, [id]);

  return (
    faculty && (
      <>
        <h1>{faculty.data.name}</h1>
        <h2>{faculty.data.address}</h2>
        <h3>Phone: {faculty.data.telephone}</h3>
      </>
    )
  );
};

export default FacultyPage;
