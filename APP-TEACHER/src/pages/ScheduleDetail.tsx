import {
  IonButtons,
  IonCol,
  IonContent,
  IonHeader,
  IonPage,
  IonRow,
  IonTitle,
  IonToast,
  IonToolbar,
} from "@ionic/react";
// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./ScheduleDetail.css";
import { IonBackButton } from "@ionic/react";
import { IonIcon } from "@ionic/react";
// import { IonReactRouter } from "@ionic/react-router";
// import { Link, Redirect, Route } from "react-router-dom";
// import Menu from "../components/Menu";
import { cubeSharp } from "ionicons/icons";
import { useEffect, useState } from "react";
import axios from "axios";

const ScheduleDetail: React.FC = () => {
  const [schedule, setSchedule] = useState([] as any[]);
  const [day, setDay] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });

    var x = localStorage.getItem("token");
    var day = localStorage.getItem("day");
    var id_school_teacher = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
      id_school_teacher: id_school_teacher,
    };
    api
      .post(`/schedule_detail_teacher/` + day, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setSchedule([]);
          } else {
            setSchedule(res.data.content);
            setDay(res.data.day);
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
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Chi tiết thời khóa biểu</IonTitle>
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
        <div
          className="row d-flex justify-content-center px-2"
          style={{ marginTop: "10px" }}
        >
          <div className="col-md-6">
            <div className="main-card mb-3 card">
              <div className="card-body">
                <h5 className="card-title mt-1 text-center fw-bold fs-4">Thời khóa biểu {day}</h5>
                <div className="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                  {schedule.map((schedule, key) => {
                    if (schedule.lesson == 1) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFCCCC",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 2) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFDAB9",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 3) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFFFCC",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 4) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#CCFFFF",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 5) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFCCFF",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 6) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#ADD8E6",
                                  
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 7) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#E0EEE0",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 8) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#D3D3D3",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 9) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFE4E1",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else if (schedule.lesson == 10) {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                 className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  backgroundColor: "#FFB6C1",
                                  borderRadius: "10px",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    } else {
                      return (
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
                            <div className="vertical-timeline-element-content bounce-in">
                              <div
                                className="shadow border border-2"
                                style={{
                                  marginLeft: "10px",
                                  padding: "10px",
                                  borderRadius: "10px",
                                  backgroundColor:"#c8b7c6",
                                }}
                              >
                                <IonRow>
                                  <IonCol className="title">Môn học:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.subject_name}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Lớp:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.class}
                                  </IonCol>
                                </IonRow>
                                <IonRow>
                                  <IonCol className="title">Phòng:</IonCol>
                                  <IonCol size="7" className="timeline-title">
                                    {schedule.classroom}
                                  </IonCol>
                                </IonRow>
                              </div>
                              <div className="vertical-timeline-element-date">
                                <p>Tiết {schedule.lesson}</p>
                                6h30-7h20
                              </div>
                            </div>
                          </div>
                        </div>
                      );
                    }
                  })}
                </div>
              </div>
            </div>
          </div>{" "}
        </div>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default ScheduleDetail;
