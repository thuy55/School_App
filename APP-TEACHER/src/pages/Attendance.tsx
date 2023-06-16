import {
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  IonLabel,
  IonButton,
  IonItem,
  IonIcon,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonModal,
  IonFab,
  IonList,
  IonAvatar,
  IonFabButton,
  IonImg,
  IonSelect,
  IonSelectOption,
  IonRow,
  IonCol,
  useIonAlert,
  IonToast,
  IonTextarea,
  IonInfiniteScroll,
  IonInfiniteScrollContent,
  IonRefresher,
  IonRefresherContent,
} from "@ionic/react";
import { useParams } from "react-router";
import ExploreContainer from "../components/ExploreContainer";
import "./Attendance.css";
import { cubeSharp, add } from "ionicons/icons";
import React, { useEffect, useRef, useState } from "react";
import axios from "axios";
const Page: React.FC = () => {
  const modal = useRef<HTMLIonModalElement>(null);

  function dismiss() {
    modal.current?.dismiss();
  }
  const [showToast, setShowToast] = useState(false);
  const [ddhs, setDdhs] = useState([] as any[]);
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
      .post(`/attendance_student_teacher`, loginData)
      .then((res) => {
        if (res.data.status === "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setDdhs([]);
          } else {
            setDdhs(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }, []);



  function getDate(e: any) {
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
      .post(`/attendance_student_teacher_search/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setDdhs([]);
          } else {
            localStorage.removeItem("date_search");
            localStorage.setItem("date_search", e);
            setDdhs(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }

  const [listStudent, setListStudent] = useState([] as any[]);
  function getListStudent(e: any) {
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
      .post(`/student_class_teacher/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            // setShowToast(true);
            setListStudent([]);
          } else {
            localStorage.removeItem("date");
            localStorage.setItem("date", e);
            setListStudent(res.data.content);
          }
        }
      })
      .catch((error) => {});
  }

  function clickStudent(e: any) {
    localStorage.removeItem("id_student");
    localStorage.setItem("id_student", e);
  }
  function clickStyle(e: any) {
    localStorage.removeItem("type");
    localStorage.setItem("type", e);
  }

  function clickTime(e: any) {
    localStorage.removeItem("check");
    localStorage.setItem("check", e);
  }
  const [presentAlert] = useIonAlert();
  const [notes, setNotes] = useState("");
  function addAttendance() {
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var id_student = localStorage.getItem("id_student");
    var id_course = localStorage.getItem("id_course");
    var type = localStorage.getItem("type");
    var date = localStorage.getItem("date");
    var check = localStorage.getItem("check");

    if (!id_student) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn học sinh",
        buttons: ["OK"],
      });
    } else if (!type) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn loại",
        buttons: ["OK"],
      });
    } else if (!date) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn ngày",
        buttons: ["OK"],
      });
    } else if (!check) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn giờ",
        buttons: ["OK"],
      });
    }
    // else if (!notes) {
    //   presentAlert({
    //     header: "Lỗi",
    //     message: "Vui lòng nhập ghi chú",
    //     buttons: ["OK"],
    //   });
    // }
    else{
    const loginData = {
      token: x,
      id_school_teacher: id,
      // id_student: id_student,
      type: type,
      date: date,
      check: check,
      notes: notes,
      id_course: id_course,
    };
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    api
      .post(`/timekeeping_add_teacher/` + id_student, loginData)
      .then((res) => {
        if (res.data.status == "error") {
          dismiss();
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          // localStorage.setItem("id_classNotification", e);
          console.log(res.data.content);
          dismiss();
          
          window.location.reload();
          localStorage.removeItem("id_student");
        }
      })
      .catch((error) => {
        dismiss();
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
    }
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
          </IonButtons>
          <IonTitle> Điểm danh học sinh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen>
      
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
        <div className="row">
          <div className="col-lg-12">
            <div className="card">
              <div
                className="card-body pt-0 "
                style={{ backgroundColor: "#f6faff" }}
              >
                <div className="card-title d-flex boder-bottom-0 mb-1">
                  <IonItem
                    className="boder-bottom-0"
                    style={{ marginTop: "10px" }}
                  >
                    <label>Chọn ngày:</label>
                    <input
                      type="date"
                      id="typeDate"
                      name="typeDate"
                      onChange={(e: any) => getDate(e.target.value)}
                    ></input>
                  </IonItem>
                  <IonCard className="w-50 m-0 mt-2">
                    <IonCardContent className="p-0 pt-1">
                      <div className="d-flex">
                        <div
                          className="pe-1 text-center"
                          style={{
                            backgroundColor: "#ffd8a8",

                            width: "50%",
                          }}
                        >
                          <h4>Phép</h4>
                        </div>
                        <div
                          className="pe-1 text-center"
                          style={{
                            backgroundColor: "#ff8787",

                            width: "50%",
                          }}
                        >
                          <h4>K phép</h4>
                        </div>
                      </div>
                      <div className="d-flex">
                        <div
                          className="pe-1 text-center bg-soft-primary"
                          style={{
                            // backgroundColor: "#ECF7EF",

                            width: "50%",
                          }}
                        >
                          <h4> Đủ</h4>
                        </div>
                        <div
                          className="pe-1 text-center"
                          style={{
                            backgroundColor: "#d8f5a2",

                            width: "50%",
                          }}
                        >
                          <h4> Thiếu</h4>
                        </div>
                      </div>
                    </IonCardContent>
                  </IonCard>
                </div>

                <div className="hori-timeline" dir="ltr">
                  <ul className="list-inline events">
                    {ddhs.map((ddhs, key) => {
                      if (ddhs.type == 0) {
                        return (
                          <li className="list-inline-item event-list w-100">
                            <div className="">
                              <div
                                className="event-date  w-100 text-primary"
                                style={{ backgroundColor: "#ff8787" }}
                              >
                                <IonRow>
                                  <IonCol>{ddhs.id_student}</IonCol>
                                  <IonCol
                                    size="9"
                                    className="text-start fw-bold"
                                  >
                                    {ddhs.firstname} {ddhs.lastname}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div
                                className="row d-flex justify-content-center px-2"
                                style={{ marginTop: "10px" }}
                              >
                                <div className="col-md-6">
                                  <div className="main-card mb-3 card">
                                    <div className="card-body p-1">
                                      <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content d-flex bounce-in">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton>Vào</IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFCCCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4  px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 204, 204)",
                                                    }}
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkin}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date pe-4">
                                                <p>Quy định vào</p>6 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content bounce-in d-flex">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton
                                                  style={{ width: "70px" }}
                                                >
                                                  Ra
                                                </IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFFFCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4 px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 255, 204)",
                                                    }}
                                                    placeholder=""
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkout}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date">
                                                <p>Quy định ra</p>5 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>{" "}
                              </div>
                            </div>
                          </li>
                        );
                      }
                      if (ddhs.type == 1) {
                        return (
                          <li className="list-inline-item event-list w-100">
                            <div className="">
                              <div className="event-date bg-soft-primary w-100 text-primary">
                                <IonRow>
                                  <IonCol>{ddhs.id_student}</IonCol>
                                  <IonCol
                                    size="9"
                                    className="text-start fw-bold"
                                  >
                                    {ddhs.firstname} {ddhs.lastname}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div
                                className="row d-flex justify-content-center px-2"
                                style={{ marginTop: "10px" }}
                              >
                                <div className="col-md-6">
                                  <div className="main-card mb-3 card">
                                    <div className="card-body p-1">
                                      <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content d-flex bounce-in">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton>Vào</IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFCCCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4  px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 204, 204)",
                                                    }}
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkin}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date pe-4">
                                                <p>Quy định vào</p>6 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content bounce-in d-flex">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton
                                                  style={{ width: "70px" }}
                                                >
                                                  Ra
                                                </IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFFFCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4 px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 255, 204)",
                                                    }}
                                                    placeholder=""
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkout}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date">
                                                <p>Quy định ra</p>5 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>{" "}
                              </div>
                            </div>
                          </li>
                        );
                      }
                      if (ddhs.type == 2) {
                        return (
                          <li className="list-inline-item event-list w-100">
                            <div className="">
                              <div
                                className="event-date w-100 text-primary"
                                style={{ backgroundColor: "#d8f5a2" }}
                              >
                                <IonRow>
                                  <IonCol>{ddhs.id_student}</IonCol>
                                  <IonCol
                                    size="9"
                                    className="text-start fw-bold"
                                  >
                                    {ddhs.firstname} {ddhs.lastname}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div
                                className="row d-flex justify-content-center px-2"
                                style={{ marginTop: "10px" }}
                              >
                                <div className="col-md-6">
                                  <div className="main-card mb-3 card">
                                    <div className="card-body p-1">
                                      <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content d-flex bounce-in">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton>Vào</IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFCCCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4  px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 204, 204)",
                                                    }}
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkin}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date pe-4">
                                                <p>Quy định vào</p>6 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content bounce-in d-flex">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton
                                                  style={{ width: "70px" }}
                                                >
                                                  Ra
                                                </IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFFFCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4 px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 255, 204)",
                                                    }}
                                                    placeholder=""
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkout}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date">
                                                <p>Quy định ra</p>5 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>{" "}
                              </div>
                            </div>
                          </li>
                        );
                      } else {
                        return (
                          <li className="list-inline-item event-list">
                            <div className="">
                              <div
                                className="event-date  w-100 text-primary"
                                style={{ backgroundColor: "#ffd8a8" }}
                              >
                                <IonRow>
                                  <IonCol>{ddhs.id_student}</IonCol>
                                  <IonCol
                                    size="9"
                                    className="text-start fw-bold"
                                  >
                                    {ddhs.firstname} {ddhs.lastname}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div
                                className="row d-flex justify-content-center px-2"
                                style={{ marginTop: "10px" }}
                              >
                                <div className="col-md-6">
                                  <div className="main-card mb-3 card">
                                    <div className="card-body p-1">
                                      <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content d-flex bounce-in">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton>Vào</IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFCCCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4  px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 204, 204)",
                                                    }}
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkin}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date pe-4">
                                                <p>Quy định vào</p>6 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div className="vertical-timeline-item vertical-timeline-element">
                                          <div>
                                            <span className="vertical-timeline-element-icon bounce-in">
                                              <IonIcon
                                                className="badge-dot-xl"
                                                icon={cubeSharp}
                                                size="large"
                                                color="tertiary"
                                              ></IonIcon>
                                            </span>
                                            <div className="vertical-timeline-element-content bounce-in d-flex">
                                              <div
                                                style={{
                                                  width: "100px",
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor:
                                                    "rgb(202 202 255)",
                                                  borderRadius: "10px",
                                                }}
                                              >
                                                <IonButton
                                                  style={{ width: "70px" }}
                                                >
                                                  Ra
                                                </IonButton>
                                              </div>
                                              <div
                                                style={{
                                                  marginLeft: "10px",
                                                  padding: "10px",
                                                  backgroundColor: "#FFFFCC",
                                                  borderRadius: "10px",
                                                  width: "50%",
                                                }}
                                              >
                                                <div>
                                                  <IonLabel
                                                    className="form-control fs-4 px-0"
                                                    style={{
                                                      background:
                                                        "rgb(255, 255, 204)",
                                                    }}
                                                    placeholder=""
                                                    aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1"
                                                  >
                                                    {ddhs.checkout}
                                                  </IonLabel>
                                                </div>
                                              </div>

                                              <div className="vertical-timeline-element-date">
                                                <p>Quy định ra</p>5 giờ 30
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>{" "}
                              </div>
                            </div>
                          </li>
                        );
                      }
                    })}
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <IonFab slot="fixed" vertical="bottom" horizontal="end">
          <IonFabButton id="open-modal2">
            <IonIcon icon={add}></IonIcon>
          </IonFabButton>
        </IonFab>
        <IonModal id="example-modal2" ref={modal} trigger="open-modal2">
          <IonContent>
            <IonToolbar>
              <IonTitle>Thêm điểm danh</IonTitle>
              <IonButtons slot="end">
                <IonButton color="light" onClick={() => dismiss()}>
                  Close
                </IonButton>
              </IonButtons>
            </IonToolbar>
            <IonList className="p-0">
              <div className="d-flex flex-row justify-content-center">
                <form className="w-xl-50 w-lg-75">
                  <div className="container mb-0 pt-0 mt-0">
                    <div className="row">
                      <div className="col-md-6">
                        <IonRow>
                          <IonCol>
                            <div className="form-group">
                              <label>Ngày điểm danh:</label>
                              <div className="input-field py-2">
                                <span className="fa fa-envelope-o px-2 py-0"></span>
                                <input
                                  type="date"
                                  required
                                  onChange={(e: any) =>
                                    getListStudent(e.target.value)
                                  }
                                />
                              </div>
                            </div>
                          </IonCol>
                          <IonCol>
                            <div className="form-group">
                              <label>Giờ điểm danh:</label>
                              <div className="input-field py-2">
                                <span className="fa fa-envelope-o px-2 py-0"></span>
                                <input
                                  type="time"
                                  required
                                  onChange={(e: any) =>
                                    clickTime(e.target.value)
                                  }
                                />
                              </div>
                            </div>
                          </IonCol>
                        </IonRow>
                        <div className="form-group">
                          {" "}
                          <label>Học sinh:</label>
                          <div className="input-field">
                            {" "}
                            <div style={{ width: "100%" }}>
                              <IonSelect
                                placeholder="Chon hoc sinh"
                                className="select-name"
                                name="form-fied-name"
                                color="primary"
                                slot="start"
                                interface="popover"
                                onIonChange={(e: any) =>
                                  clickStudent(e.target.value)
                                }
                              >
                                {listStudent.map((listStudent, key) => {
                                  return (
                                    <IonSelectOption
                                      key={key}
                                      value={listStudent.id_arrange_class}
                                    >
                                      {listStudent.firstname}{" "}
                                      {listStudent.lastname}
                                    </IonSelectOption>
                                  );
                                })}
                              </IonSelect>
                            </div>
                          </div>
                        </div>
                        <div className="form-group">
                          <label>Loại:</label>
                          <div className="input-field">
                            <div style={{ width: "100%" }}>
                              <IonSelect
                                placeholder="Chon hoc sinh"
                                className="select-name"
                                name="form-fied-name"
                                color="primary"
                                slot="start"
                                interface="popover"
                                onIonChange={(e: any) =>
                                  clickStyle(e.target.value)
                                }
                              >
                                <IonSelectOption value="1">
                                  Giờ vào
                                </IonSelectOption>
                                <IonSelectOption value="2">
                                  Giờ ra
                                </IonSelectOption>
                              </IonSelect>
                            </div>
                          </div>
                        </div>

                        <label>Ghi chú:</label>
                        <IonItem
                          fill="outline"
                          style={{ width: "100%", marginTop: "20px" }}
                        >
                          {/* <IonLabel position="floating">
                            Nội dung góp ý
                          </IonLabel> */}
                          {/* <div style={{height:"200px"}}> */}
                          <IonTextarea
                            className="px-2"
                            placeholder="Ghi chú"
                            onIonChange={(e: any) => setNotes(e.target.value)}
                          ></IonTextarea>

                          {/* </div> */}
                        </IonItem>
                      </div>

                      {/* <div className="col-md-6">
                        <div className="form-group">
                          <label>Lý do:</label>
                          <div className="input-field bg-light">
                            <textarea
                              name="message"
                              id="msg"
                              className="form-control bg-light"
                              placeholder="Lý do"
                            ></textarea>
                          </div>
                        </div>
                      </div> */}
                      <div className="d-flex flex-row justify-content-center w-100">
                        {/* <input type="button" value="Gửi" className="btn"/> */}
                        <IonButton
                          onClick={addAttendance}
                          expand="block"
                          className="mt-4"
                        >
                          Gửi
                        </IonButton>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </IonList>
          </IonContent>
        </IonModal>
        {/* <IonInfiniteScroll onIonInfinite={loadMoreLogs}>
           <IonInfiniteScrollContent loadingSpinner="bubbles" />
          </IonInfiniteScroll> */}
      </IonContent>
    </IonPage>
  );
};

export default Page;
function fetchDataFromSource() {
  throw new Error("Function not implemented.");
}

