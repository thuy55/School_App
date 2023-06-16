import {
  IonButtons,
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,IonBreadcrumb,IonBreadcrumbs
} from "@ionic/react";
import { useParams } from "react-router";
import { IonItem, IonLabel } from "@ionic/react";
import { IonIcon } from "@ionic/react";
import { arrowBackOutline,home,notifications ,newspaper} from "ionicons/icons";
import { Link } from "react-router-dom";
import {
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,IonBackButton
} from "@ionic/react";
import axios from "axios";
import React, { useState, useEffect } from "react";
import { IonFooter } from "@ionic/react";

const NotificationDetail: React.FC = () => {
  const [notificationSchool_detail, setNotificationSchool_detail] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_notification");
    // var idNo = localStorage.getItem("idNo");
    const loginData = {
      token: x,
      id_notification: id,
    };
    api
      .post(`/school_announcement_detail/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setNotificationSchool_detail(res.data.content);
          
           console.log("xoa");
        }
        
        
      })
      .catch((error) => {});
  }, []);
  return (
    <IonPage>
      <IonHeader >
        <IonToolbar>
          <IonButtons slot="start">
          <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Chi tiết thông báo</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
     
      {notificationSchool_detail.map((notificationSchool_detail, key) => {
          return (
        <IonCard className="m-0 p-0">
          <IonCardHeader className="p-0">
            
          <IonCard className="card_none">
              <IonCardHeader className="card_h">
                <IonCardTitle className="triangle"><p className="text text-white m-0 ps-1 pe-0 ">SỞ GIÁO DỤC & ĐÀO TẠO TPHCM </p></IonCardTitle>
              </IonCardHeader>

              <IonCardContent className="content">
              {notificationSchool_detail.name}
              </IonCardContent>
              <IonCardContent className="p-2">
              <IonBreadcrumbs>
                <IonBreadcrumb className="p-0" href="/dashboard">
                 Trang chủ
                  <IonIcon className="p-0"  slot="end" icon={home}></IonIcon>
                </IonBreadcrumb>
                <IonBreadcrumb  className="p-0" href="/news">
                  Tin
                  <IonIcon slot="end" icon={newspaper}></IonIcon>
                </IonBreadcrumb>
                <IonBreadcrumb  className="p-0" href="/notifications">
                  Thông báo
                  <IonIcon slot="end" icon={notifications}></IonIcon>
                </IonBreadcrumb>
               
              </IonBreadcrumbs>
              </IonCardContent>
            </IonCard>
          </IonCardHeader>
          {/* <IonCardContent className="content border-bottom-0 text-center">
              {notificationSchool_detail.name}
              </IonCardContent> */}
          <IonCardContent style={{ textAlign: "justify", border: "1px solid" ,padding: "11px",margin: "6px"}}>
          {notificationSchool_detail.content}
          </IonCardContent>
          <IonFooter>
            <IonToolbar>
              <IonItem slot="start" className="ms-2" style={{color:"#e35050"}} >{notificationSchool_detail.description}</IonItem>
              <IonItem slot="end" style={{color:"#2185eb"}}> {notificationSchool_detail.date}</IonItem>
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
