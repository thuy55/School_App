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
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonAvatar,
  IonItem,
  IonChip,
  IonText,
} from "@ionic/react";
import moment from "moment";

import "./Home.css";
import { IonLabel } from "@ionic/react";
import { IonBreadcrumb, IonBreadcrumbs } from "@ionic/react";
import { home, notifications, newspaper } from "ionicons/icons";

import { IonSearchbar } from "@ionic/react";

import React, { useEffect, useState } from "react";
import { IonList, IonThumbnail } from "@ionic/react";
import { IonCol, IonRow } from "@ionic/react";
import { IonIcon } from "@ionic/react";
import { image, earth, call, location } from "ionicons/icons";
import { Link } from "react-router-dom";
import axios from "axios";
const Home: React.FC = () => {
  const current = new Date();
  const date = `${current.getDate()}/${
    current.getMonth() + 1
  }/${current.getFullYear()}`;
  const [news, setNews] = useState([] as any[]);
  const [newss, setNewss] = useState([] as any[]);
  const [notificationSchool, setNotificationSchool] = useState([] as any[]);
  const [cleanedContent, setCleanedContent] = useState<string>('');


  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });

    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");

    const loginData = {
      token: x,
      id_school_teacher: id,
    };
    api
      .post(`/news_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status === "success") {
          setNews(res.data.news);
          setNotificationSchool(res.data.school_announcement);
          // const content = res.data.news.content;
          // console.log("aaaaa", res.data.news.content);
          // const cleanedContent = content.replace(/"/g, "");
          // setCleanedContent(cleanedContent);
          
        }
      })
      .catch((error) => {});
  }, []);

  function handleItemClick(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("id_notification");
    localStorage.setItem("id_notification", itemId);
  }

  function handleItemClickNew(e: any) {
    const itemId2 = e.target.id;
    localStorage.removeItem("id_newsDetail");
    localStorage.setItem("id_newsDetail", itemId2);
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
          </IonButtons>
          <IonTitle>Hoạt động trường</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonLabel>
          <div className="titie2 ">Hoạt động tiêu biểu</div>
        </IonLabel>
        <IonItem className="itemTt">
          <div className="container2">
            <div id="carousel">
              <figure>
                <img src="https://edu.viettel.vn/upload/49555/fck/files/cb4d9baaa7ed5ab303fc.jpg" />
              </figure>
              <figure>
                <img src="https://kinhtenongthon.vn/srv_thumb.ashx?w=300&h=200&f=data/data/Baoinktnt/2017/Thang%2011/Ngay%2024/tr13.JPG" />
              </figure>
              <figure>
                <img src="https://cdnmedia.baotintuc.vn/Upload/gYJXHsn6VBCJnSv7rj8xYQ/files/2022/04/anhdo.jpg" />
              </figure>
              <figure>
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRzlhxXOkqcxaDelO0kpUFTWLSvQeyYaz-woQ&usqp=CAU" />
              </figure>
              <figure>
                <img src="https://lawnet.vn/uploads/image/2020/02/12/084151060.jpg" />
              </figure>
              <figure>
                <img src="https://lawnet.vn/uploads/image/2020/02/12/084151060.jpg" />
              </figure>
              <figure>
                <img src="https://media.baodansinh.vn/files/content/2022/01/19/mam-non-151911.jpg" />
              </figure>
              <figure>
                <img src="https://i.imgur.com/DjwL2R8.jpg" />
              </figure>
              <figure>
                <img src="https://i.imgur.com/ZCeK0MQ.jpg" />
              </figure>
            </div>
          </div>
        </IonItem>
        <IonItem className="itemTt2">
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
        </IonItem>
        <IonSearchbar></IonSearchbar>
        <div className="list-group">
          {news.map((newss, key) => {
            return (
              <>
                <Link
                  to="/News_open"
                  className="list-group-item p-0 list-group-item-action"
                  onClick={handleItemClickNew}
                  key={newss.id}
                  id={newss.id}
                >
                  <IonCard className="card-news cl">
                    <img
                      onClick={handleItemClickNew}
                      key={newss.id}
                      id={newss.id}
                      alt="avatar"
                      src={`${newss.avatar}`}
                    />
                    <IonCardHeader
                      className="pd"
                      onClick={handleItemClickNew}
                      key={newss.id}
                      id={newss.id}
                    >
                      <IonCardTitle
                        className="font"
                        onClick={handleItemClickNew}
                        key={newss.id}
                        id={newss.id}
                      >
                        {newss.name}
                      </IonCardTitle>
                    </IonCardHeader>
                    <IonCardContent
                      className="news"
                      onClick={handleItemClickNew}
                      key={newss.id}
                      id={newss.id}
                    >
                      <IonLabel className="text-content-home">
                        <IonText>
                          {newss.description}
                        {/* <div dangerouslySetInnerHTML={{ __html: newss.content }}></div> */}
                        </IonText>
                      </IonLabel>

                      <IonCardSubtitle
                        className="color-tt"
                        onClick={handleItemClickNew}
                        key={newss.id}
                        id={newss.id}
                      >
                        Ngày đăng tải:
                        {moment(newss.date).format("DD-MM-YYYY")}
                      </IonCardSubtitle>
                      <IonCardSubtitle className="color-11">
                        Đọc thêm...
                      </IonCardSubtitle>
                      <IonCardSubtitle className=""></IonCardSubtitle>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </>
            );
          })}
        </div>
        <IonCard>
          <IonCardHeader className="notifile">
            <IonCardTitle>Thông báo mới</IonCardTitle>
            <IonCardSubtitle className="colordate">
              {/* ngày 22/12/2022 */}
            </IonCardSubtitle>
          </IonCardHeader>
          <IonCardContent className="pg">
            {notificationSchool.map((notificationSchool, key) => {
              return (
                <>
                  <IonList>
                    <Link to="/NotificationDetail">
                      <IonItem
                        className="item-inner"
                        button
                        detail={true}
                        onClick={handleItemClick}
                        id={notificationSchool.id}
                        key={notificationSchool.id}
                      >
                        <IonThumbnail className="img" slot="start">
                          <img
                            onClick={handleItemClick}
                            id={notificationSchool.id}
                            key={notificationSchool.id}
                            className="img2"
                            alt="Silhouette of mountains"
                            src={`${notificationSchool.avatar}`}
                          />
                        </IonThumbnail>
                        <IonLabel>
                          <IonRow>
                            <IonCol>
                              <IonLabel>
                                <h2>{notificationSchool.name}</h2>
                                <div className="dp">
                                  <IonIcon
                                    className="icondownload"
                                    icon={image}
                                  ></IonIcon>{" "}
                                  <div className="noti">
                                    {notificationSchool.description}
                                  </div>
                                </div>
                              </IonLabel>
                            </IonCol>
                          </IonRow>
                        </IonLabel>
                      </IonItem>
                    </Link>
                  </IonList>
                </>
              );
            })}
            <IonCardHeader className="notifile2">
              <IonCardSubtitle className="colordate">
                <IonRow>
                  <IonCol className="text1" size="6">
                    {date}
                  </IonCol>
                  <IonCol className="text2" size="6">
                    Xem thêm...
                  </IonCol>
                </IonRow>
              </IonCardSubtitle>
            </IonCardHeader>
          </IonCardContent>

         
        </IonCard>
      </IonContent>
    </IonPage>
  );
};

export default Home;
