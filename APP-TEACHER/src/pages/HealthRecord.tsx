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
  IonSelect,
  IonSelectOption,
  IonBackButton,
} from "@ionic/react";
import axios from "axios";
// import { useParams } from 'react-router';
// import ExploreContainer from '../components/ExploreContainer';
import "./HealthRecord.css";
import { IonLabel, IonCol, IonGrid, IonRow } from "@ionic/react";
// import { IonList, IonSelect, IonSelectOption, IonIcon, IonThumbnail } from '@ionic/react';
// import { IonReactRouter } from '@ionic/react-router';
// import { Link, Redirect, Route } from 'react-router-dom';
// import Menu from '../components/Menu';
import {
  fitnessOutline,
  gitNetworkOutline,
  resizeOutline,
  scaleOutline,
  sparklesOutline,
  thermometerOutline,
} from "ionicons/icons";
import { useEffect, useState } from "react";
import moment from "moment";

const HealthRecord: React.FC = () => {
  const [infoStudent, setInfoStudent] = useState([] as any[]);
  const [infoStudentBody, setInfoStudentBody] = useState([] as any[]);
  const [health, setHealth] = useState([] as any[]);
  const [vacxin, setVacxin] = useState([] as any[]);
  const [student, setStudent] = useState([] as any[]);
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
      .post(`/health_student_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setStudent(res.data.liststudent);
        }
      })
      .catch((error) => {});
  }, []);

  function getHealth(e: any) {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id = localStorage.getItem("id_school_teacher");
    // var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
      id_school_teacher: id,
      // id_course: id_course,
    };

    api
      .post(`/health_student_teacher_click/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          localStorage.removeItem("id_student");
          localStorage.setItem("id_student", e);
          setInfoStudent(res.data.content.health_insurance_id);
          setInfoStudentBody(res.data.content.body_insurance_id);
          setHealth(res.data.health);
          setVacxin(res.data.vaccination);
        }
      })
      .catch((error) => {});
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Hồ sơ sức khỏe</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonCard className="card-home">
          <IonCardContent className="card-content">
            <IonGrid className="grid">
              <IonRow className="row align-items-center d-flex">
                <IonCol>
                  <IonLabel className="lable-name">Tên học sinh:</IonLabel>
                </IonCol>
                <IonCol size="8">
                  <div style={{ width: "100%" }}>
                    <IonSelect
                      className="select-name border border-1"
                      slot="start"
                      interface="popover"
                      placeholder="Chọn học sinh"
                      style={{ backgroundColor: "rgb(231, 220, 220)" }}
                      onIonChange={(e: any) => getHealth(e.target.value)}
                    >
                      {student.map((student, key) => {
                        return (
                          <IonSelectOption key={key} value={student.id}>
                            {student.firstname} {student.lastname}
                          </IonSelectOption>
                        );
                      })}
                    </IonSelect>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
            
                  <IonGrid className="py-0">
                    <IonRow className="row">
                      <IonCol>
                        <IonLabel className="lable-name">Mã BHYT :</IonLabel>
                      </IonCol>
                      <IonCol className="tt" size="8">
                        {infoStudent}
                      </IonCol>
                    </IonRow>
                  </IonGrid>
                
                  <IonGrid className="py-0">
                    <IonRow className="row">
                      <IonCol>
                        <IonLabel className="lable-name">
                          Mã BHTT :
                        </IonLabel>
                      </IonCol>
                      <IonCol className="tt" size="8">
                        {infoStudentBody}
                      </IonCol>
                    </IonRow>
                  </IonGrid>
                
          </IonCardContent>
        
        </IonCard>

        <div className="card border-0 border-top mt-3">
          <div className="card-header">
            <ul
              className="nav nav-pills  d-flex justify-content-around"
              id="pills-tab"
              role="tablist"
            >
              <li className="nav-item" role="presentation">
                <button
                  className="nav-link active"
                  id="pills-home-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-home"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true"
                >
                  Tổng quan
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className="nav-link"
                  id="pills-profile-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-ts"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected="false"
                >
                  Tiểu sử
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  className="nav-link"
                  id="pills-contact-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-tc"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected="false"
                >
                  Tiêm chủng
                </button>
              </li>
            </ul>
          </div>
          <form className="px-3 tab-content">
            <div className="tab-pane active" id="nav-home">
              <div className="row d-flex justify-content-between mt-1">
                <div className="w-50 d-flex justify-content-center">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-danger">
                        <div className="w-25">
                          <IonIcon
                            icon={fitnessOutline}
                            className="icon-list"
                            color="danger"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-3">
                          {health.map((health, key) => {
                            return <b>{health.heartbeat}</b>;
                          })}

                          <h6 className="mt-2">Nhịp/phút</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-2">
                        <b>Nhịp tim</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Đo lúc :</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
                <div className="w-50 d-flex justify-content-center">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-warning">
                        <div className="w-25">
                          <IonIcon
                            icon={gitNetworkOutline}
                            className="icon-list"
                            color="warning"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-2">
                          {health.map((health, key) => {
                            return <b>{health.blood_pressure}</b>;
                          })}
                          <h6 className="mt-2">mmHg</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-2">
                        <b>Huyết áp</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Đo lúc :</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="row d-flex justify-content-between ">
                <div className="w-50 d-flex justify-content-center ">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-success">
                        <div className="w-25">
                          <IonIcon
                            icon={thermometerOutline}
                            className="icon-list"
                            color="success"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-3">
                          {health.map((health, key) => {
                            return <b>{health.temperature}</b>;
                          })}

                          <h6 className="mt-2">°C</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-2">
                        <b>Nhiệt độ</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Đo lúc :</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
                <div className="w-50 d-flex justify-content-center">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-primary">
                        <div className="w-25">
                          <IonIcon
                            icon={sparklesOutline}
                            className="icon-list"
                            color="primary"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-4">
                          {health.map((health, key) => {
                            // console.log(health.weight);
                            const bmi = (
                              health.weight /
                              ((health.height / 100) * (health.height / 100))
                            ).toFixed(2);
                            return <b>{bmi}</b>;
                          })}

                          <h6 className="mt-2">kg/m²</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-2">
                        <b>Chỉ số BMI</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Tính lúc:</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="row d-flex justify-content-between">
                <div className="w-50 d-flex justify-content-center ">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-info">
                        <div className="w-25">
                          <IonIcon
                            icon={scaleOutline}
                            className="icon-list"
                            color="secondary"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-3">
                          {health.map((health, key) => {
                            return <b>{health.weight}</b>;
                          })}
                          <h6 className="mt-2">kg</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-3">
                        <b>Cân nặng</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Cân lúc :</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
                <div className="w-50 d-flex justify-content-center">
                  <div className="card w-100 bg-white rounded-4 border border-2 shadow">
                    <div className="card-body text-center py-0 pt-2 p-1">
                      <div className="d-flex justify-content-between text-secondary">
                        <div className="w-25">
                          <IonIcon
                            icon={resizeOutline}
                            className="icon-list"
                            color="medium"
                          ></IonIcon>
                        </div>
                        <div className="w-75 fs-1 ms-4">
                          {health.map((health, key) => {
                            return <b>{health.height}</b>;
                          })}
                          <h6 className="mt-2">cm</h6>
                        </div>
                      </div>
                      <div className="d-flex fs-5 ms-2">
                        <b>Chiều cao</b>
                      </div>
                      <div className="d-flex ms-2">
                        <h6>Đo lúc:</h6>
                      </div>
                      <div className="d-flex ms-2">
                        {health.map((health, key) => {
                          return (
                            <h6 className="mt-1">
                              {moment(health.date).format("DD-MM-YYYY")}
                            </h6>
                          );
                        })}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="tab-pane" id="nav-ts">
              <div className=" card-text fs-6">
                Tiền sử bệnh án <br></br>
                {health.map((health, key) => {
                  return <b className="fs-5">{health.prehistoric}</b>;
                })}
              </div>
            </div>
            <div className="tab-pane" id="nav-tc">
              {vacxin.map((vacxin, key) => {
                return (
                  <div
                    className="card rounded-4 mt-3"
                    color="#FFF0F5"
                    style={{ backgroundColor: "rgb(102 67 6)" }}
                  >
                    <div className="card-header">
                      <h5 className="mt-1 text-warning mb-0 fw-bold">
                        {vacxin.name}
                      </h5>
                    </div>
                    <div
                      className="card-content p-3 rounded-4 text-start"
                      style={{ backgroundColor: "#e6c68d" }}
                      color="#FFF0F5"
                    >
                      <div className="row align-content-center d-flex">
                        <h6 className="col-5">Tên Vacxin:</h6>
                        <p className="col-7 fs-6 mb-2">{vacxin.namevacxin}</p>
                      </div>
                      <div className="row">
                        <h6 className="col-5">Ngày tiêm:</h6>
                        <p className="col-7 fs-6 mb-0">
                          {moment(vacxin.date).format("DD-MM-YYYY")}
                        </p>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          </form>
        </div>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default HealthRecord;
