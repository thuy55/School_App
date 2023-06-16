import {
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonCard,
  IonCardContent,
  IonIcon,
  IonButton,
  IonInput,
  IonToast,
  IonBackButton,
} from "@ionic/react";
import "./Move.css";

import { IonLabel, IonCol, IonGrid, IonRow } from "@ionic/react";
import { Link } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import { key } from "ionicons/icons";
import moment from "moment";
const HealthRecord: React.FC = () => {
  const [go, setGo] = useState([] as any[]);
  const [today, settoday] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");

    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
    };

    api
      .post(`/car_schedule_go_teacher/` + id, loginData)
      .then((res) => {
        settoday(res.data.today);
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setGo([]);
          } else {
            const i = res.data.today;
            localStorage.setItem("today2", i);
            setGo(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }, []);

  const [back, setBack] = useState([] as any[]);

  function getToday(e: any) {
    // const itemId = e.target.id;
    // console.log(itemId);
    // localStorage.removeItem("type_Go_Back");
    // localStorage.setItem("type_Go_Back", itemId);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
    };
    api
      .post(`/car_schedule_go_teacher_search/` + e, loginData)
      .then((res) => {
        settoday(res.data.today);
        if (res.data.status == "success") {
          if (res.data.go == null) {
            // setShowToast(true);
            // localStorage.removeItem("today2");
            // localStorage.setItem("today2", e);
            setGo([]);
          }  else {
            localStorage.removeItem("today2");
            localStorage.setItem("today2", e);
            setGo(res.data.go);
            setBack(res.data.back);
          }
          if (res.data.back == null) {
            // setShowToast(true);
            // localStorage.removeItem("today2");
            // localStorage.setItem("today2", e);
            setBack([]);
          } else {
            localStorage.removeItem("today2");
            localStorage.setItem("today2", e);
            setGo(res.data.go);
            setBack(res.data.back);
          }
        }
      })
      .catch((error) => {});
  }

  function getScheduleBack(e: any) {
    const itemId = e.target.id;
    console.log(itemId);
    localStorage.removeItem("type_Go_Back");
    localStorage.setItem("type_Go_Back", itemId);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id = localStorage.getItem("id_school_teacher");
    var today = localStorage.getItem("today2");
    var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
    };

    api
      .post(`/car_schedule_comeback_teacher/` + today, loginData)
      .then((res) => {
        settoday(res.data.today);
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setBack([]);
          } else {
            // localStorage.removeItem("today2");
            // localStorage.setItem("today2", e);
            setBack(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }

  function handleItemClick(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("id_schedule");
    localStorage.setItem("id_schedule", itemId);
    console.log(itemId);
  }

  // function handleGoBack(event: any) {
  //   const itemId = event.target.id;
  //   localStorage.removeItem("id_driver");
  //   localStorage.setItem("id_driver", itemId);
  //   console.log(itemId);
  // }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Đưa đón học sinh</IonTitle>
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
        <IonCard className="card-home-cash">
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              <IonRow className="row px-3 align-items-center d-flex">
                <IonCol>
                  <IonLabel className="lable-name">Ngày :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <IonInput
                      type="date"
                      onIonChange={(e: any) => getToday(e.target.value)}
                      placeholder="chọn ngày"
                      className="bg-white p-1"
                    ></IonInput>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>
        <div className="card border-0 mb-0 border-top mt-0">
          <div className="card-header">
            <ul
              className="nav nav-pills  d-flex justify-content-around"
              id="pills-tab"
              role="tablist"
            >
              <li className="nav-item" role="presentation">
                <button
                  className="nav-link active"
                  id="1"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-home"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true"
                >
                  Xe đón đi
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  onClick={getScheduleBack}
                  className="nav-link"
                  id="2"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-ts"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected="false"
                >
                  Xe đón về
                </button>
              </li>
            </ul>
          </div>
          <form className="card-body tab-content p-0">
            <div className="tab-pane active" id="nav-home">
              <div className="page-content page-container" id="page-content">
                <div className="">
                  <div className="row">
                    <div className="col-lg-6">
                      <div className="timeline mb-0 p-1 pt-3 block mb-4">
                        {go.map((go, key) => {
                          // if (go.day_of_week == "Thứ 2") {
                          return (
                            <div className="tl-item active">
                              <div className="tl-dot1">
                                <a
                                  className="tl-author"
                                  href="#"
                                  data-abc="true"
                                >
                                  <span className="w-100 p-2  avatar2 circle text-white gd-warning ">
                                    {moment(go.date).format("DD-MM-YYYY")}
                                  </span>
                                </a>
                              </div>
                              <div className="tl-content w-100">
                                {/* <div className="tl-date text-muted mt-1">
                                  {moment(go.date).format("DD-MM-YYYY")}
                                </div> */}
                                <IonCard
                                  className="me-2 move-1"
                                  style={{ backgroundColor: "#FFCCCC" }}
                                >
                                  <IonCardContent>
                                    <IonGrid className="">
                                      <IonRow className="pt-1">
                                        <IonCol className="text-2">
                                          Loại xe
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {go.typecar}
                                        </IonCol>
                                      </IonRow>
                                      <IonRow className="pt-3">
                                        <IonCol className="text-2">
                                          Biển số:
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {go.license_plates}
                                        </IonCol>
                                      </IonRow>
                                      <IonRow className="pt-3">
                                        <IonCol className="text-2">
                                          tài xế:{" "}
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {go.namedriver}
                                        </IonCol>
                                      </IonRow>

                                      <Link to="/ProfileDriver">
                                        <IonButton
                                          expand="block"
                                          className="mt-3"
                                          onClick={handleItemClick}
                                          key={go.id_schedule}
                                          id={go.id_schedule}
                                        >
                                          Xem thêm...
                                        </IonButton>
                                      </Link>
                                    </IonGrid>
                                  </IonCardContent>
                                </IonCard>
                              </div>
                            </div>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="nav-ts">
              <div className="page-content page-container" id="page-content">
                <div className="">
                  <div className="row">
                    <div className="col-lg-6">
                      <div className="timeline mb-0 p-1 pt-3 block mb-4">
                        {back.map((back, key) => {
                          return (
                            <div className="tl-item active">
                              <div className="tl-dot1">
                                <a
                                  className="tl-author"
                                  href="#"
                                  data-abc="true"
                                >
                                  <span className="w-100 p-2 avatar2 circle text-white gd-warning ">
                                    {moment(back.date).format("DD-MM-YYYY")}
                                  </span>
                                </a>
                              </div>
                              <div className="tl-content w-100">
                                {/* <div className="tl-date text-muted mt-1">
                                  {moment(back.date).format("DD-MM-YYYY")}
                                </div> */}
                                <IonCard
                                  className="me-2 move-1"
                                  style={{ backgroundColor: "#FFCCCC" }}
                                >
                                  <IonCardContent>
                                    <IonGrid className="">
                                      <IonRow className="pt-1">
                                        <IonCol className="text-2">
                                          Loại xe
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {back.typecar}
                                        </IonCol>
                                      </IonRow>
                                      <IonRow className="pt-3">
                                        <IonCol className="text-2">
                                          Biển số:
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {back.license_plates}
                                        </IonCol>
                                      </IonRow>
                                      <IonRow className="pt-3">
                                        <IonCol className="text-2">
                                          tài xế:{" "}
                                        </IonCol>
                                        <IonCol className="text-1" size="7">
                                          {back.namedriver}
                                        </IonCol>
                                      </IonRow>

                                      <Link to="/ProfileDriver">
                                        <IonButton
                                          expand="block"
                                          className="mt-3"
                                          onClick={handleItemClick}
                                          key={back.id_schedule}
                                          id={back.id_schedule}
                                        >
                                          Xem thêm...
                                        </IonButton>
                                      </Link>
                                    </IonGrid>
                                  </IonCardContent>
                                </IonCard>
                              </div>
                            </div>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </IonContent>
    </IonPage>
  );
};

export default HealthRecord;
