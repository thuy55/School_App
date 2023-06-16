import {
  IonButtons,
  IonContent,
  IonHeader,
  IonBackButton,
  IonPage,
  IonTitle,
  IonToolbar,
} from "@ionic/react";
import { useParams } from "react-router";
import "./News_open.css";
import {
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
} from "@ionic/react";
import { IonBreadcrumb, IonBreadcrumbs, IonIcon, IonLabel } from "@ionic/react";
import { home, notifications, newspaper } from "ionicons/icons";
import { useEffect, useState } from "react";
import axios from "axios";
const Page: React.FC = () => {
  // const { name } = useParams<{ name: string }>();

  const [newDetails, setNewDetails] = useState([] as any[]);

  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    var id = localStorage.getItem("id_newsDetail");
    const loginData = {
      token: x,
      
    };
    api
      .post(`/news-detail/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setNewDetails(res.data.content);
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
          <IonTitle>Tin tức</IonTitle>
        </IonToolbar>
      </IonHeader>

      <IonContent fullscreen>
        <IonCard className="card_none">
          <IonCardHeader className="card_h">
            <IonCardTitle className="triangle">
              <p className="text">SỞ GIÁO DỤC VÀ ĐÀO TẠO TPHCM</p>
            </IonCardTitle>
          </IonCardHeader>

          <IonCardContent className="content">
            HOẠT ĐỘNG KÉO CO TẠI TRƯỜNG HỌC NGÀY 22/12/22222
          </IonCardContent>
          <IonCardContent className="p-2">
            <IonBreadcrumbs>
              <IonBreadcrumb href="/dashboard">
                Home
                <IonIcon slot="end" icon={home}></IonIcon>
              </IonBreadcrumb>
              <IonBreadcrumb href="/notifications">
                Thông báo
                <IonIcon slot="end" icon={notifications}></IonIcon>
              </IonBreadcrumb>
              <IonBreadcrumb href="/news">
                Tin tức
                <IonIcon slot="end" icon={newspaper}></IonIcon>
              </IonBreadcrumb>
            </IonBreadcrumbs>
          </IonCardContent>
        </IonCard>
        {newDetails.map((newDetails, key) => {
          return (
            <IonCard>
              <img
                alt="avatar"
                src={`${newDetails.avatar}`}
              />
              {/* <IonCardSubtitle className="anh">
                Hình 1: Hoạt động đầu giờ của trường
              </IonCardSubtitle> */}
              <IonCardContent className="text-justify">
              <div dangerouslySetInnerHTML={{ __html: newDetails.content }}></div>
              {/* {newDetails.content} */}
              </IonCardContent>
            </IonCard>
          );
        })}
      </IonContent>
    </IonPage>
  );
};

export default Page;
