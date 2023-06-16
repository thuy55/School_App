import {
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonChip,
  IonToast,
  IonBackButton,
} from "@ionic/react";

import "./Meals.css";
import { Link } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import { log } from "console";

const Meals: React.FC = () => {
  const [meals, setMeals] = useState([] as any[]);
  const [day, setDays] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id_school_teacher = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
      id_school_teacher: id_school_teacher,
    };
    api
      .post(`/menu_teacher`, loginData)
      .then((res) => {
        if (res.data.status === "success") {
          if (res.data.monday == null) {
            setShowToast(true);
            setMeals([]);
          } else {
            setMeals(res.data.monday);
            // setDays(res.data.monday);
          }
        }
      })
      .catch((error) => {});
  }, []);

  function handleItemClick(event: any) {
    const itemId = event.target.id;
    console.log(itemId);
    localStorage.removeItem("id_Day");
    localStorage.setItem("id_Day", itemId);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_Day");
    var id_school_teacher = localStorage.getItem("id_school_teacher");

    const loginData = {
      token: x,
      id_Day: id,
      id_school_teacher:id_school_teacher,
    };
    api
      .post(`/menu_day_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setDays([]);
          } else {
          
            setDays(res.data.content);
            console.log(id);
          }
        }
      })
      .catch((error) => {});
  }
  function handleItemClickMeal(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("id_MealDetails");
    localStorage.setItem("id_MealDetails", itemId);
    console.log(itemId);
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start" style={{ color: "#f08c00" }}>
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Thực đơn</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonToast
          isOpen={showToast}
          message="Không tìm thấy dữ liệu."
          duration={3000}
          onDidDismiss={() => setShowToast(false)}
          position="top"
          color="danger"
          cssClass="my-toast"
          buttons={[
            {
              text: "Đóng",
              role: "cancel",
              handler: () => {
                setShowToast(false);
              },
            },
          ]}
        />
        <div style={{ marginTop: "10px" }}>
          <ul
            className="nav nav-pills mx-3  w-100 "
            id="pills-tab"
            role="tablist"
            style={{ overflowX: "scroll" }}
          >
            <li className="nav-item" role="presentation">
              <button
                className="nav-link active"
                id="1"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu2"
                type="button"
                role="tab"
                aria-controls="pills-thu2"
                aria-selected="true"
              >
                T2
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="2"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu3"
                type="button"
                role="tab"
                aria-controls="pills-thu3"
                aria-selected="false"
              >
                T3
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="3"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu4"
                type="button"
                role="tab"
                aria-controls="pills-thu4"
                aria-selected="false"
              >
                T4
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="4"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu5"
                type="button"
                role="tab"
                aria-controls="pills-thu5"
                aria-selected="false"
              >
                T5
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="5"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu6"
                type="button"
                role="tab"
                aria-controls="pills-thu6"
                aria-selected="false"
              >
                T6
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="6"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-thu7"
                type="button"
                role="tab"
                aria-controls="pills-thu7"
                aria-selected="false"
              >
                T7
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button
                className="nav-link"
                id="7"
                onClick={handleItemClick}
                data-bs-toggle="pill"
                data-bs-target="#pills-chunhat"
                type="button"
                role="tab"
                aria-controls="pills-chunhat"
                aria-selected="false"
              >
                CN
              </button>
            </li>
          </ul>
        </div>

        <div className="tab-content mt-2" id="pills-tabContent">
          <div
            className="tab-pane fade show active"
            id="pills-thu2"
            role="tabpanel"
            aria-labelledby="1"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {meals.map((day, key) => {
                      
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {meals.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {meals.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-thu3"
            role="tabpanel"
            aria-labelledby="2"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-thu4"
            role="tabpanel"
            aria-labelledby="3"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-thu5"
            role="tabpanel"
            aria-labelledby="4"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                 
                    {day.map((day, key) => {
                       
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                  
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-thu6"
            role="tabpanel"
            aria-labelledby="5"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-thu7"
            role="tabpanel"
            aria-labelledby="6"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
          <div
            className="tab-pane fade"
            id="pills-chunhat"
            role="tabpanel"
            aria-labelledby="7"
          >
            <>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",
                  backgroundImage: `linear-gradient(140deg, #93291e 50% , #ed213a 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa sáng
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa sáng") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #087f5b 50% , #0ca678 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa trưa
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa trưa") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
              <IonChip
                className="fs-5"
                style={{
                  color: "white",

                  backgroundImage: `linear-gradient(140deg, #364fc7 50% , #4c6ef5 75%)`,
                  marginBottom: "12px",
                  marginLeft: "14px",
                }}
              >
                Bữa chiều
              </IonChip>
              <div className="mealsss">
                <div
                  className="meals d-flex gap-3 mx-3"
                  style={{ overflowX: "scroll" }}
                >
                  <ul className="d-flex list-unstyled">
                    {day.map((day, key) => {
                      if (day.typemenu === "Bữa chiều") {
                        return (
                          <>
                            <Link
                              to="./MealsDetail"
                              onClick={handleItemClickMeal}
                              key={day.id}
                              id={day.id}
                            >
                              <li
                                onClick={handleItemClickMeal}
                                key={day.id}
                                id={day.id}
                                style={{
                                  width: "173px",
                                  marginRight: "14px",
                                }}
                              >
                                <div
                                  className="rounded-4 overflow-hidden shadow-sm border bg-white"
                                  onClick={handleItemClickMeal}
                                  key={day.id}
                                  id={day.id}
                                >
                                  <img
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                    src={`${day.avatar}`}
                                    alt="..."
                                    style={{
                                      width: "172px",
                                      height: "140px",
                                    }}
                                  />
                                  <div
                                    className="card-title text-dark text-center fw-bold p-1 mt-2"
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    {day.namefood}
                                  </div>
                                  <p
                                    className="card-text text-center fs-6 p-1 my-2 fw-bold"
                                    style={{ color: "#d6336c" }}
                                    onClick={handleItemClickMeal}
                                    key={day.id}
                                    id={day.id}
                                  >
                                    507 Kcal
                                  </p>
                                </div>
                              </li>
                            </Link>
                          </>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </>
          </div>
        </div>
      </IonContent>
    </IonPage>
  );
};
export default Meals;
