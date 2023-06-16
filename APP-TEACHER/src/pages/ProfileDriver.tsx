// import { useParams } from "react-router";
import {
  IonCol,
  IonGrid,
  IonRow,
  IonPage,
  IonHeader,
  IonToolbar,
  IonButtons,
  IonMenuButton,
  createAnimation,
  IonTitle,
  IonContent,
  IonLabel,
  IonButton,
  IonModal,
  IonList,
  IonItem,
  IonInput,
  IonTextarea,
  IonFooter,
  IonTabsContext,
  IonTabButton,
  IonIcon,
  IonCardContent,
  IonCardTitle,
  IonBackButton,
  IonCard,
  IonAccordionGroup,
  IonAccordion,
  IonAvatar,
} from "@ionic/react";
import { useHistory } from "react-router-dom";
import { useLocation } from "react-router-dom";
import { home, key, library, navigateCircleOutline, playCircle, radio, search } from "ionicons/icons";
import "./Account.css";
import React, { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
// import { removeUserSession } from "./Common";
import axios from "axios";
import moment from "moment";

const Account: React.FC = () => {
  // const location = useLocation();
  // const history = useHistory();
  // const handleLogout = () => {
  //   removeUserSession();
  //   history.push('/');
  // }
  // const modal = useRef<HTMLIonModalElement>(null);

  // function dismiss() {
  //   modal.current?.dismiss();
  // }

  // const enterAnimation = (baseEl: HTMLElement) => {
  //   const root = baseEl.shadowRoot;

  //   const backdropAnimation = createAnimation()
  //     .addElement(root?.querySelector("ion-backdrop")!)
  //     .fromTo("opacity", "0.01", "var(--backdrop-opacity)");

  //   const wrapperAnimation = createAnimation()
  //     .addElement(root?.querySelector(".modal-wrapper")!)
  //     .keyframes([
  //       { offset: 0, opacity: "0", transform: "scale(0)" },
  //       { offset: 1, opacity: "0.99", transform: "scale(1)" },
  //     ]);

  //   return createAnimation()
  //     .addElement(baseEl)
  //     .easing("ease-out")
  //     .duration(500)
  //     .addAnimation([backdropAnimation, wrapperAnimation]);
  // };

  // const leaveAnimation = (baseEl: HTMLElement) => {
  //   return enterAnimation(baseEl).direction("reverse");
  // };

  const [driver, setDriver] = useState([] as any[]);
  const [ward, setWard] = useState([] as any[]);
  const [district, setDistrict] = useState([] as any[]);
  const [province, setProvince] = useState([] as any[]);
  const [student_schedule, setstudent_schedule] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);
  const [route, setroute] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var date = localStorage.getItem("today");
    var id_schedule = localStorage.getItem("id_schedule");
    var type = localStorage.getItem("type_Go_Back");
    var id_course = localStorage.getItem("id_course");
    var id = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
      // today: date,
      id_schedule: id_schedule,
      type_Go_Back: type,
      id_course: id_course,
      id_school_teacher: id,
    };

    api
      .post(`/car_driver_teacher/` + id_schedule, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setDriver(res.data.driver);

          setWard(res.data.ward);
          setDistrict(res.data.district);
          setProvince(res.data.province);
          setroute(res.data.route);
          if (res.data.student_schedule == null) {
            // setShowToast(true);
            setstudent_schedule([]);
          } else {
            setstudent_schedule(res.data.student_schedule);
          }
        }
      })
      .catch((error) => {});
  }, []);
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Thông tin chuyến xe</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
        <article className="bg-xl pb-2">
          <div className=" before-bg-style">
            {driver.map((driver, key) => {
              return (
                <div className="profile">
                  <div className="avatar">
                    <img
                      className="avatar-img"
                      src={`${driver.avatar}`}
                      alt="Avatar Driver"
                    />
                  </div>
                  <IonCardContent className="bg-3 ms-0 me-0 profile ps-2">
                    <IonGrid className="pv mt-4">
                      <IonRow className="align-items-center my-2">
                        <IonCol>Tên tài xế:</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>{driver.name}</IonInput>
                        </IonCol>
                      </IonRow>

                      <IonRow className="align-items-center my-2">
                        <IonCol>Số điện thoại:</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>{driver.phone_number}</IonInput>
                        </IonCol>
                      </IonRow>

                      <IonRow className="align-items-center my-2">
                        <IonCol>Ngày sinh:</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>
                            {moment(driver.birthday).format("DD-MM-YYYY")}
                          </IonInput>
                        </IonCol>
                      </IonRow>

                      <IonRow className="align-items-center my-2">
                        <IonCol>Giới tính :</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>{driver.gender}</IonInput>
                        </IonCol>
                      </IonRow>
                      <IonRow className="align-items-center my-2">
                        <IonCol>CMND/CCCD:</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>{driver.citizenId}</IonInput>
                        </IonCol>
                      </IonRow>

                      <IonRow className="align-items-center my-2">
                        <IonCol>Bằng lái xe :</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>{driver.driver_license_id}</IonInput>
                        </IonCol>
                      </IonRow>
                      <IonRow className="align-items-center my-2">
                        <IonCol>Ngày bắt đầu:</IonCol>
                        <IonCol className="text-1" size="7">
                          <IonInput>
                            {moment(driver.date_start_work).format(
                              "DD-MM-YYYY"
                            )}
                          </IonInput>
                        </IonCol>
                      </IonRow>
                      <IonRow className="align-items-center my-2">
                        <IonCol>Địa chỉ:</IonCol>
                        <IonCol className="text-1" size="7">
                          {driver.address} {ward} {district} {province}
                        </IonCol>
                      </IonRow>
                    </IonGrid>
                  </IonCardContent>
                </div>
              );
            })}
          </div>
        </article>
        <IonAccordionGroup className="px-3 pb-4 mt-2">
          <div className="fw-bold d-flex align-items-center mb-3">
            <IonIcon
              icon={navigateCircleOutline}
              size="large"
              color="warning"
            ></IonIcon>
            Tuyến đường: {route}
          </div>
          <IonLabel className="fw-bold text-danger">
            Danh sách học sinh:
          </IonLabel>
          {student_schedule.map((student_schedule, key) => {
            return (
              <IonAccordion className="mt-2 acc">
                <IonItem
                  slot="header"
                  color="red"
                  className="item-teacher-1 ps-0"
                >
                  <IonAvatar slot="start" className="ms-3">
                    <img
                      alt="Avatar Student"
                      src={`${student_schedule.avatar}`}
                    />
                  </IonAvatar>
                  <IonLabel className="fw-bold">
                    {student_schedule.firstname} {student_schedule.lastname}
                    <p className="mt-2 text-secondary">
                      Mã học sinh : {student_schedule.id_student}
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="ion-padding p-0 pe-2" slot="content">
                  {/* <p
                    className="link text-center mt-2"
                    style={{ background: "#e3edf5" }}
                  >
                    <img
                      className="img-teacher w-50  rounded-circle"
                      alt="Silhouette of mountains"
                      src="https://ionicframework.com/docs/img/demos/thumbnail.svg"
                    />
                  </p> */}
                  <ol id="accordion" className="rounded-list accordion">
                    <li>
                      <ol>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Họ và tên :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {student_schedule.firstname}{" "}
                                {student_schedule.lastname}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">Lớp:</IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {student_schedule.id_student}
                              </IonCol>
                            </IonRow>{" "}
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Mã HS:
                                </IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {student_schedule.id_student}
                              </IonCol>
                            </IonRow>{" "}
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Ngày sinh :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {moment(student_schedule.birthday).format(
                                  "DD-MM-YYYY"
                                )}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Giới tính :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {student_schedule.gender}
                              </IonCol>
                            </IonRow>
                          </p>
                        </li>
                        <li>
                          <p className="link">
                            <IonRow className="row text-align-center">
                              <IonCol>
                                <IonLabel className="lable-name">
                                  Nhập học :
                                </IonLabel>
                              </IonCol>
                              <IonCol size="8" className="nd">
                                {moment(
                                  student_schedule.year_of_admission
                                ).format("DD-MM-YYYY")}
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
          })}
        </IonAccordionGroup>
      </IonContent>

      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Account;
