import {
  IonBackButton,
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
} from "@ionic/react";
import { IonItem } from "@ionic/react";
import { checkmarkDoneOutline } from "ionicons/icons";
import { Link } from "react-router-dom";
import { IonChip, IonAvatar, IonLabel, IonIcon } from "@ionic/react";
import axios from "axios";
import React, { useState, useRef, useEffect } from "react";
const { localStorage } = window;
// import TabApp from "./TabApp";
const Notifications: React.FC = () => {
  const [notificationSchool, setNotificationSchool] = useState([] as any[]);

  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id = localStorage.getItem("id_school_teacher");
    // var idNo = localStorage.getItem("idNo");
    const loginData = {
      token: x,
      id_school_teacher: id,
    };
    api
      .post(`/school_announcement_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setNotificationSchool(res.data.content);
        }
      })
      .catch((error) => {});
  }, []);
  function handleItemClick(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("id_notification");
    localStorage.setItem("id_notification", itemId);

    // Lưu itemId vào state hoặc thực hiện các xử lý khác tùy vào nhu cầu của bạn
  }
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start" style={{ color: "#f08c00" }}>
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          {/* <IonButtons slot="end">
            <IonIcon
              icon={checkmarkDoneOutline}
              size="large"
              style={{ color: "#f08c00" }}
            ></IonIcon>
          </IonButtons> */}
          <IonTitle>Thông báo</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container m-4">
        <div className="ms-3">
          {notificationSchool.map((notificationSchool, key) => {
            return (
              <Link to="/NotificationDetail">
                <IonItem
                  onClick={handleItemClick}
                  key={notificationSchool.id}
                  id={notificationSchool.id}
                  button
                  detail={true}
                >
                  <IonAvatar
                    onClick={handleItemClick}
                    key={notificationSchool.id}
                    id={notificationSchool.id}
                  >
                    <img onClick={handleItemClick}
                    key={notificationSchool.id}
                    id={notificationSchool.id}
                      alt="Silhouette of a person's head"
                      src="https://png.pngtree.com/png-vector/20191103/ourlarge/pngtree-handsome-young-guy-avatar-cartoon-style-png-image_1947775.jpg"
                    />
                  </IonAvatar>
                  <IonLabel style={{ marginLeft: "10px" }}>
                    <h2>{notificationSchool.name} </h2>
                    <p>{notificationSchool.content}</p>
                    <IonChip style={{ margin: 0 }}>
                      <IonAvatar>
                        <img
                          alt="Silhouette of a person's head"
                          src="https://png.pngtree.com/png-vector/20191103/ourlarge/pngtree-handsome-young-guy-avatar-cartoon-style-png-image_1947775.jpg"
                        />
                      </IonAvatar>
                      <IonLabel className="d-flex">
                        {notificationSchool.description},{" "}
                        <b className="text-danger  m-0">
                          {notificationSchool.date}
                        </b>
                      </IonLabel>
                    </IonChip>
                  </IonLabel>
                </IonItem>
              </Link>
            );
          })}
        </div>
      </IonContent>
    </IonPage>
  );
};

export default Notifications;
