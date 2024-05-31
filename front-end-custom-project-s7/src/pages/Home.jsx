import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const Home = () => {
  const [faculties, setFaculties] = useState([]);

  useEffect(() => {
    fetch(`/api/v1/faculties`)
      .then(res => res.json())
      .then(data => setFaculties(data))
      .catch(err => console.log(err));
  }, []);

  return (
    <>
      {faculties.map(faculty => (
        <div key={faculty.id}>
          <h2>{faculty.name}</h2>
          <Link to={`/faculties/${faculty.id}`}>Dettagli</Link>
          <ul>
            {faculty.degrees.map(degree => (
              <li key={degree.id}>{degree.name}</li>
            ))}
          </ul>
        </div>
      ))}
    </>
  );
};

export default Home;
