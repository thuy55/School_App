import {
  IonButtons,
  IonAccordion,
  IonAccordionGroup,
  IonItem,
  IonLabel,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonRow,
  IonCol,
  IonToast,
  IonButton,
  useIonAlert,
  IonIcon,
  IonBackButton,
} from "@ionic/react";

// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Debt.css";
import { useEffect, useRef, useState } from "react";
import axios from "axios";
import moment from "moment";
import { busSharp } from "ionicons/icons";

const RegisterCar: React.FC = () => {
  const [car, setCar] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);

  useEffect(() => {
    console.log("vvvv");
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
      .post(`/students_register_car_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          console.log("aaaaaaaa");
          if (res.data.content == null) {
            setShowToast(true);
            setCar([]);
          } else {
            setCar(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }, []);

  function infocar(e: any) {
    const id = e.target.id;
    localStorage.setItem("id_car", id);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    console.log("ccccccc", id);
    var x = localStorage.getItem("token");
    const loginData = {
      token: x,
    };
    api
      .post(`/students-register_car_detail_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          console.log("bbbbb");
        }
      })
      .catch((error) => {});
  }
  const [presentAlert] = useIonAlert();
  function duyet() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_car = localStorage.getItem("id_car");
    const loginData = {
      token: x,
    };
    api
      .post(`/students_register_car_browser_teacher/` + id_car, loginData)
      .then((res) => {
        if (res.data.status == "error") {
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log(res.data.content);
          window.location.reload();
        }
      })
      .catch((error) => {
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
  }

  function tuchoi() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_car = localStorage.getItem("id_car");
    const loginData = {
      token: x,
    };
    api
      .post(
        `/students_register_car__delete_browser_teacher/` + id_car,
        loginData
      )
      .then((res) => {
        if (res.data.status == "error") {
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log(res.data.content);
          window.location.reload();
        }
      })
      .catch((error) => {
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Đăng kí dịch vụ xe</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
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

        <IonAccordionGroup className="px-3">
          {car.map((car, key) => {
            if (car.statu == "D") {
              return (
                <IonAccordion
                  value={car.id_student_register_car}
                  className="mt-3 acc"
                  onClick={infocar}
                  key={key}
                  id={car.id_student_register_car}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash ps-0"
                    onClick={infocar}
                    key={car.id_student_register_car}
                    id={car.id_student_register_car}
                  >
                    <div
                      className="item-count ms-2 bg-success"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      <IonIcon
                        icon={busSharp}
                        size="large"
                        style={{ marginBottom: 1, color: "white" }}
                      ></IonIcon>
                      {/* P */}
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      Học sinh: {car.firstname} {car.lastname}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        <IonCol
                          className="ps-0 col-5"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <p
                            className="text-secondary"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            Học kì : {car.semester}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-start"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <p
                            className="text-secondary"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            Khóa: {car.course}
                          </p>
                        </IonCol>
                      </IonRow>
                    </IonLabel>
                  </IonItem>
                  <div className="ion-padding p-0 pe-2" slot="content">
                    <ol id="accordion" className="rounded-list accordion">
                      <li>
                        <ol>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học sinh :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.firstname} {car.lastname}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học kì :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.semester}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Khóa học :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.course}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Tuyến đường:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.route}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Trạng thái:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  Đã duyệt
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                        </ol>
                      </li>
                    </ol>
                  </div>
                </IonAccordion>
              );
            } else if (car.statu == "C") {
              return (
                <IonAccordion
                  value={car.id_student_register_car}
                  className="mt-3 acc"
                  onClick={infocar}
                  key={key}
                  id={car.id_student_register_car}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash ps-0"
                    onClick={infocar}
                    key={car.id_student_register_car}
                    id={car.id_student_register_car}
                  >
                    <div
                      className="item-count ms-2 bg-danger"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      <IonIcon
                        icon={busSharp}
                        size="large"
                        style={{ marginBottom: 1, color: "white" }}
                      ></IonIcon>
                      {/* P */}
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      Học sinh: {car.firstname} {car.lastname}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        <IonCol
                          className="ps-0 col-5"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <p
                            className="text-secondary"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            Học kì : {car.semester}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-start"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <p
                            className="text-secondary"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            Khóa: {car.course}
                          </p>
                        </IonCol>
                      </IonRow>
                    </IonLabel>
                  </IonItem>
                  <div className="ion-padding p-0 pe-2" slot="content">
                    <ol id="accordion" className="rounded-list accordion">
                      <li>
                        <ol>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học sinh :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.firstname} {car.lastname}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học kì :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.semester}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Khóa học :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.course}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Tuyến đường:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {car.route}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Trạng thái:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  Từ chối
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                        </ol>
                      </li>
                    </ol>
                  </div>
                </IonAccordion>
              );
            } else {
              if (car.view == 0) {
                return (
                  <IonAccordion
                    value={car.id_student_register_car}
                    className="mt-3 acc"
                    onClick={infocar}
                    key={key}
                    id={car.id_student_register_car}
                  >
                    <IonItem
                      slot="header"
                      color="red"
                      className="item-Cash ps-0"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      <div
                        className="item-count ms-2 bg-warning"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        <IonIcon
                          icon={busSharp}
                          size="large"
                          style={{ marginBottom: 1, color: "white" }}
                        ></IonIcon>
                        {/* P */}
                      </div>
                      <IonLabel
                        className="fw-bold"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        Học sinh: {car.firstname} {car.lastname}
                        <IonRow
                          className="d-flex align-items-center w-100 mt-2"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <IonCol
                            className="ps-0 col-5"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            <p
                              className="text-secondary"
                              onClick={infocar}
                              key={car.id_student_register_car}
                              id={car.id_student_register_car}
                            >
                              Học kì : {car.semester}
                            </p>
                          </IonCol>
                          <IonCol
                            className="text-start"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            <p
                              className="text-secondary"
                              onClick={infocar}
                              key={car.id_student_register_car}
                              id={car.id_student_register_car}
                            >
                              Khóa: {car.course}
                            </p>
                          </IonCol>
                        </IonRow>
                      </IonLabel>
                    </IonItem>
                    <div className="ion-padding p-0 pe-2" slot="content">
                      <ol id="accordion" className="rounded-list accordion">
                        <li>
                          <ol>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Học sinh :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.firstname} {car.lastname}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Học kì :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.semester}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Khóa học :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.course}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Tuyến đường:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.route}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Trạng thái:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    Chưa duyệt
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                          </ol>
                        </li>
                      </ol>
                      <IonRow className="d-flex justify-content-center mb-2">
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75 "
                            color={"danger"}
                            onClick={tuchoi}
                          >
                            TỪ CHỐI
                          </IonButton>
                        </IonCol>
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75"
                            color={"success"}
                            onClick={duyet}
                          >
                            DUYỆT
                          </IonButton>
                        </IonCol>
                      </IonRow>
                    </div>
                  </IonAccordion>
                );
              } else {
                return (
                  <IonAccordion
                    value={car.id_student_register_car}
                    className="mt-3 acc"
                    onClick={infocar}
                    key={key}
                    id={car.id_student_register_car}
                  >
                    <IonItem
                      slot="header"
                      color="red"
                      className="item-Cash11 ps-0"
                      onClick={infocar}
                      key={car.id_student_register_car}
                      id={car.id_student_register_car}
                    >
                      <div
                        className="item-count ms-2 bg-warning"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        <IonIcon
                          icon={busSharp}
                          size="large"
                          style={{ marginBottom: 1, color: "white" }}
                        ></IonIcon>
                        {/* P */}
                      </div>
                      <IonLabel
                        className="fw-bold"
                        onClick={infocar}
                        key={car.id_student_register_car}
                        id={car.id_student_register_car}
                      >
                        Học sinh: {car.firstname} {car.lastname}
                        <IonRow
                          className="d-flex align-items-center w-100 mt-2"
                          onClick={infocar}
                          key={car.id_student_register_car}
                          id={car.id_student_register_car}
                        >
                          <IonCol
                            className="ps-0 col-5"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            <p
                              className="text-secondary"
                              onClick={infocar}
                              key={car.id_student_register_car}
                              id={car.id_student_register_car}
                            >
                              Học kì : {car.semester}
                            </p>
                          </IonCol>
                          <IonCol
                            className="text-start"
                            onClick={infocar}
                            key={car.id_student_register_car}
                            id={car.id_student_register_car}
                          >
                            <p
                              className="text-secondary"
                              onClick={infocar}
                              key={car.id_student_register_car}
                              id={car.id_student_register_car}
                            >
                              Khóa: {car.course}
                            </p>
                          </IonCol>
                        </IonRow>
                      </IonLabel>
                    </IonItem>
                    <div className="ion-padding p-0 pe-2" slot="content">
                      <ol id="accordion" className="rounded-list accordion">
                        <li>
                          <ol>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Học sinh :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.firstname} {car.lastname}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Học kì :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.semester}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Khóa học :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.course}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Tuyến đường:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {car.route}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Trạng thái:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    Chưa duyệt
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                          </ol>
                        </li>
                      </ol>
                      <IonRow className="d-flex justify-content-center mb-2">
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75 "
                            color={"danger"}
                            onClick={tuchoi}
                          >
                            TỪ CHỐI
                          </IonButton>
                        </IonCol>
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75"
                            color={"success"}
                            onClick={duyet}
                          >
                            DUYỆT
                          </IonButton>
                        </IonCol>
                      </IonRow>
                    </div>
                  </IonAccordion>
                );
              }
            }
          })}
        </IonAccordionGroup>
      </IonContent>
    </IonPage>
  );
};

export default RegisterCar;
