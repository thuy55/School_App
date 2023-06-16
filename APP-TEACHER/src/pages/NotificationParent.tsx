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
  IonAvatar,
  IonCard,
  IonCardContent,
  IonGrid,
  IonSelect,
  IonSelectOption,
  IonInput,
  IonAlert,
  IonToast,
  IonIcon,
  IonBackButton,
  IonFab,
  IonFabButton,
  IonModal,
  createAnimation,
  IonButton,
  IonTextarea,
  useIonAlert,
} from "@ionic/react";

// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Debt.css";
import { useEffect, useRef, useState } from "react";
import axios from "axios";
import {
  addCircleOutline,
  addOutline,
  closeCircleOutline,
  closeOutline,
} from "ionicons/icons";
import moment from "moment";

const NotificationParent: React.FC = () => {
  const [notificationParent, setNotificationParent] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);
  const [type, setType] = useState();
  const [currentPage, setCurrentPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);

 

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
        .post(`/parent_announcement_teacher`, loginData)
        .then((res) => {
          if (res.data.status == "success") {
            setType(res.data.type);
            if (res.data.content == null) {
              setShowToast(true);
              setNotificationParent([]);
            } else {
              setNotificationParent(res.data.content);
            }
          }
        })
        .catch((error) => {});
    }, []);

  function info(e: any) {
    const id = e.target.id;
    localStorage.setItem("id_notificationParent", id);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    console.log("ccccccc", id);
    var x = localStorage.getItem("token");
    const loginData = {
      token: x,
    };
    api
      .post(`/parent_announcement_detail_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          console.log("bbbbb");
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
          <IonTitle>Phụ huynh thông báo</IonTitle>
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
          {notificationParent.map((notificationParent, key) => {
            if (notificationParent.view == "0") {
              return (
                <IonAccordion
                  value={notificationParent.id}
                  className="mt-3 acc"
                  onClick={info}
                  key={key}
                  id={notificationParent.id}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash ps-0"
                    onClick={info}
                    key={notificationParent.id}
                    id={notificationParent.id}
                  >
                    <div
                      className="item-count ms-2 bg-success"
                      onClick={info}
                      key={notificationParent.id}
                      id={notificationParent.id}
                    >
                      P
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={info}
                      key={notificationParent.id}
                      id={notificationParent.id}
                    >
                      Tiêu đề: {notificationParent.name}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={info}
                        key={notificationParent.id}
                        id={notificationParent.id}
                      >
                        <IonCol
                          className="ps-0"
                          onClick={info}
                          key={notificationParent.id}
                          id={notificationParent.id}
                        >
                          <p
                            className="text-secondary"
                            onClick={info}
                            key={notificationParent.id}
                            id={notificationParent.id}
                          >
                            {notificationParent.firstname}{" "}
                            {notificationParent.lastname}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-end"
                          onClick={info}
                          key={notificationParent.id}
                          id={notificationParent.id}
                        >
                          <h6
                            className="text-danger"
                            onClick={info}
                            key={notificationParent.id}
                            id={notificationParent.id}
                          >
                            {moment(notificationParent.date).format(
                              "DD-MM-YYYY"
                            )}
                          </h6>
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
                                    Tiêu đề :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.name}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Mô tả :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.description}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Nội dung :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.content}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học sinh:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.firstname}{" "}
                                  {notificationParent.lastname}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Ngày:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {moment(notificationParent.date).format(
                                    "DD-MM-YYYY"
                                  )}
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
              return (
                <IonAccordion
                  value={notificationParent.id}
                  className="mt-3 acc"
                  onClick={info}
                  key={notificationParent.id}
                  id={notificationParent.id}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash11 ps-0"
                    onClick={info}
                    key={notificationParent.id}
                    id={notificationParent.id}
                  >
                    <div
                      className="item-count ms-2"
                      onClick={info}
                      style={{ backgroundColor: "primary" }}
                      key={notificationParent.id}
                      id={notificationParent.id}
                    >
                      P
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={info}
                      key={notificationParent.id}
                      id={notificationParent.id}
                    >
                      Tiêu đề: {notificationParent.name}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={info}
                        key={notificationParent.id}
                        id={notificationParent.id}
                      >
                        <IonCol
                          className="ps-0"
                          onClick={info}
                          key={notificationParent.id}
                          id={notificationParent.id}
                        >
                          <p
                            className="text-secondary"
                            onClick={info}
                            key={notificationParent.id}
                            id={notificationParent.id}
                          >
                            {notificationParent.firstname}{" "}
                            {notificationParent.lastname}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-end"
                          onClick={info}
                          key={notificationParent.id}
                          id={notificationParent.id}
                        >
                          <h6
                            className="text-danger"
                            onClick={info}
                            key={notificationParent.id}
                            id={notificationParent.id}
                          >
                            {moment(notificationParent.date).format(
                              "DD-MM-YYYY"
                            )}
                          </h6>
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
                                    Tiêu đề :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.name}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Mô tả :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.description}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Nội dung :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.content}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Học sinh:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {notificationParent.firstname}{" "}
                                  {notificationParent.lastname}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Ngày:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {moment(notificationParent.date).format(
                                    "DD-MM-YYYY"
                                  )}
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
            }
          })}
        </IonAccordionGroup>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default NotificationParent;
