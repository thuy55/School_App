import {
  IonButtons,
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
  IonBreadcrumb,
  IonBreadcrumbs,
  IonBackButton,
} from "@ionic/react";
import { useParams } from "react-router";
import { IonItem, IonLabel } from "@ionic/react";
import { IonIcon } from "@ionic/react";
import {
  arrowBackOutline,
  home,
  notifications,
  newspaper,
} from "ionicons/icons";
import { Link } from "react-router-dom";
import {
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
} from "@ionic/react";
import axios from "axios";
import React, { useState, useEffect } from "react";
import { IonFooter } from "@ionic/react";
import moment from "moment";

const NotificationDetail: React.FC = () => {
  const [notificationTeacher_detail, setNotificationTeacher_detail] = useState(
    [] as any[]
  );
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_notificationTeacher");
    // var idNo = localStorage.getItem("idNo");
    const loginData = {
      token: x,
      id_notificationTeacher: id,
    };
    api
      .post(`/teacher_announcement_detail/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setNotificationTeacher_detail(res.data.content);
          localStorage.removeItem("id_notificationTeacher");
          console.log("xoa");
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
          <IonTitle>Chi tiết thông báo</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        {notificationTeacher_detail.map((notificationTeacher_detail, key) => {
          return (
            <IonCard className="m-0 p-0">
              <IonCardHeader className="p-0">
                <IonCard className="card_none">
                  <IonCardHeader className="card_h">
                    <IonCardTitle className="triangle">
                      <p className="text text-white m-0 ps-1 pe-0 ">
                        SỞ GIÁO DỤC & ĐÀO TẠO TPHCM{" "}
                      </p>
                    </IonCardTitle>
                  </IonCardHeader>

                  <IonCardContent className="content">
                    {notificationTeacher_detail.name}
                  </IonCardContent>
                  <IonCardContent className="p-2">
                    <IonBreadcrumbs>
                      <IonBreadcrumb className="p-0" href="/dashboard">
                        Trang chủ
                        <IonIcon
                          className="p-0"
                          slot="end"
                          icon={home}
                        ></IonIcon>
                      </IonBreadcrumb>
                      {/* <IonBreadcrumb className="p-0" href="/news">
                        Tin
                        <IonIcon slot="end" icon={newspaper}></IonIcon>
                      </IonBreadcrumb> */}
                      <IonBreadcrumb className="p-0" href="/notificationTeacher">
                        Thông báo giáo viên
                        <IonIcon slot="end" icon={notifications}></IonIcon>
                      </IonBreadcrumb>
                    </IonBreadcrumbs>
                  </IonCardContent>
                </IonCard>
              </IonCardHeader>
              <IonCardContent style={{ textAlign: "justify", border: "1px solid" ,padding: "11px",margin: "6px"}}>
                {notificationTeacher_detail.content}
              </IonCardContent>
              <IonFooter>
                <IonToolbar>
                  {/* <IonItem slot="start">
                    Giáo viên: {notificationTeacher_detail.first_teacher}{" "}
                    {notificationTeacher_detail.last_teacher}
                  </IonItem> */}
                  <IonItem slot="end" className="text-danger fs-6">{moment(notificationTeacher_detail.date).format("DD-MM-YYYY")}</IonItem>
                </IonToolbar>
              </IonFooter>
            </IonCard>
          );
        })}
      </IonContent>
    </IonPage>
  );
};

export default NotificationDetail;
