import {
  createAnimation,
  IonButtons,
  IonContent,
  IonHeader,
  IonMenuButton,
  IonPage,
  IonTitle,
  IonToolbar,
  useIonAlert,
} from "@ionic/react";

import { addOutline, checkmarkDoneOutline, closeOutline } from "ionicons/icons";
import { Link } from "react-router-dom";
import { IonChip, IonAvatar, IonLabel } from "@ionic/react";
import {
  IonFab,
  IonFabButton,
  IonFabList,
  IonIcon,
  IonTextarea,
  IonRow,
  IonCol,
} from "@ionic/react";
import { IonModal, IonImg } from "@ionic/react";
import {
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonInput,
  IonButton,
} from "@ionic/react";
import React, { useState, useRef, useEffect } from "react";
import { IonItem, IonList, IonSelect, IonSelectOption } from "@ionic/react";
import axios from "axios";
import moment from "moment";

// import TabApp from "./TabApp";
const NotificationsTeacher: React.FC = () => {
  // const { name } = useParams<{ name: string }>();

  const modal = useRef<HTMLIonModalElement>(null);

  function dismiss() {
    modal.current?.dismiss();
  }

  const enterAnimation = (baseEl: HTMLElement) => {
    const root = baseEl.shadowRoot;

    const backdropAnimation = createAnimation()
      .addElement(root?.querySelector("ion-backdrop")!)
      .fromTo("opacity", "0.01", "var(--backdrop-opacity)");

    const wrapperAnimation = createAnimation()
      .addElement(root?.querySelector(".modal-wrapper")!)
      .keyframes([
        { offset: 0, opacity: "0", transform: "scale(0)" },
        { offset: 1, opacity: "0.99", transform: "scale(1)" },
      ]);

    return createAnimation()
      .addElement(baseEl)
      .easing("ease-out")
      .duration(500)
      .addAnimation([backdropAnimation, wrapperAnimation]);
  };

  const leaveAnimation = (baseEl: HTMLElement) => {
    return enterAnimation(baseEl).direction("reverse");
  };

  const [notificationTeacher, setNotificationTeacher] = useState([] as any[]);

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
      id_course:id_course,
    };
    api
      .post(`/teacher_announcement_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setNotificationTeacher(res.data.content);
        }
      })
      .catch((error) => {});
  }, []);

  function handleItemClick(event2: any) {
    const itemId = event2.target.id;
    localStorage.removeItem("id_notificationTeacher");
    localStorage.setItem("id_notificationTeacher", itemId);
    console.log(itemId);

    // Lưu itemId vào state hoặc thực hiện các xử lý khác tùy vào nhu cầu của bạn
  }

  function clickClass(e: any) {
    localStorage.removeItem("id_classNotification");
    localStorage.setItem("id_classNotification", e);

  }

  const [classTeacher, setClassTeacher] = useState([] as any[]);
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
      id_course:id_course,
    };
    api
      .post(`/class_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setClassTeacher(res.data.class);
        }
      })
      .catch((error) => {});
  }, []);

  const [presentAlert] = useIonAlert();

  const [name, setName] = useState("");
  // const [clas, setClas] = useState("");
  const [description, setDescription] = useState("");
  const [content, setContent] = useState("");
  
  function addNotificationTeacher() {
    var clas = localStorage.getItem("id_classNotification");
   
    if (!name) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập tiêu đề thông báo",
        buttons: ["OK"],
      });
    } else if (!description) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập miêu tả thông báo",
        buttons: ["OK"],
      });
    } else if (!content) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập nội dung thông báo",
        buttons: ["OK"],
      });
    }
    else if (!clas) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn lớp",
        buttons: ["OK"],
      });
    }
    else{

 
    // localStorage.setItem("id_classNotification", e);
    var id = localStorage.getItem("id_school_teacher");
    var x = localStorage.getItem("token");
   
    const add_opinion = {
      name: name,
      description: description,
      content: content,
      token: x,
      id_school_teacher: id,
    };

    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    api
      .post("/announcement_add_teacher/" + clas, add_opinion)
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
          localStorage.removeItem("id_classNotification");
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
          <IonButtons slot="start" style={{ color: "#f08c00" }}>
            <IonMenuButton />
          </IonButtons>

          <IonTitle>Thông báo giáo viên</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonCard>
          {notificationTeacher.map((notificationTeacher, key) => {
            return (
              <Link to="/NotificationTeacherDetail">
                <IonItem
                  button
                  detail={true}
                  onClick={handleItemClick}
                  key={notificationTeacher.id}
                  id={notificationTeacher.id}
                >
                  <IonAvatar
                    className="ms-2"
                    onClick={handleItemClick}
                    key={notificationTeacher.id}
                    id={notificationTeacher.id}
                  >
                    <img
                      onClick={handleItemClick}
                      key={notificationTeacher.id}
                      id={notificationTeacher.id}
                      alt="Silhouette of a person's head"
                      src="https://png.pngtree.com/png-vector/20191103/ourlarge/pngtree-handsome-young-guy-avatar-cartoon-style-png-image_1947775.jpg"
                    />
                  </IonAvatar>
                  <IonLabel
                    style={{ marginLeft: "10px" }}
                    onClick={handleItemClick}
                    key={notificationTeacher.id}
                    id={notificationTeacher.id}
                  >
                    <p className="text-dark">
                      Gửi tới lớp: {notificationTeacher.class}
                    </p>
                    <h2>{notificationTeacher.name}</h2>
                    <p>{notificationTeacher.content}</p>
                    <IonChip
                      className="w-100"
                      style={{ margin: 0 }}
                      onClick={handleItemClick}
                      key={notificationTeacher.id}
                      id={notificationTeacher.id}
                    >
                      <IonAvatar>
                        <img
                          alt="Silhouette of a person's head"
                          src="https://png.pngtree.com/png-vector/20191103/ourlarge/pngtree-handsome-young-guy-avatar-cartoon-style-png-image_1947775.jpg"
                        />
                      </IonAvatar>
                      <IonLabel className="d-flex ">
                        {notificationTeacher.description}
                        <b className="text-danger ms-2 m-0">
                          {moment(notificationTeacher.date).format(
                            "DD-MM-YYYY"
                          )}
                        </b>
                      </IonLabel>
                    </IonChip>
                  </IonLabel>
                </IonItem>
              </Link>
            );
          })}
        </IonCard>

        <IonFab slot="fixed" vertical="bottom" horizontal="end" id="open-modal">
          <IonFabButton>
            <IonIcon icon={addOutline}></IonIcon>
          </IonFabButton>
        </IonFab>
        <IonModal
          id="example-modal"
          ref={modal}
          trigger="open-modal"
          enterAnimation={enterAnimation}
          leaveAnimation={leaveAnimation}
          style={{ alignItems: "start", height: "61%" }}
        >
          <IonContent>
            <IonToolbar>
              <IonTitle color={"white"} style={{ textAlign: "center" }}>
                Thông báo giáo viên
              </IonTitle>
              <IonButtons slot="end">
                <IonButton onClick={() => dismiss()}>
                  <IonIcon color={"white"} icon={closeOutline}></IonIcon>
                </IonButton>
              </IonButtons>
            </IonToolbar>
            <IonCard>
              <IonCardContent style={{ height: "100%" }}>
                <IonItem>
                  <IonLabel position="floating">Tiêu đề</IonLabel>
                  <IonInput
                    placeholder="Nhập tiêu đề"
                    onIonChange={(e: any) => setName(e.target.value)}
                  ></IonInput>
                </IonItem>
                <IonItem>
                  <IonLabel position="floating">Miêu tả</IonLabel>
                  <IonInput
                    placeholder="Miêu tả"
                    onIonChange={(e: any) => setDescription(e.target.value)}
                  ></IonInput>
                </IonItem>
                <IonItem>
                  <IonLabel position="floating">Nội dung</IonLabel>
                  <IonInput
                    placeholder="Nhập nội dung"
                    onIonChange={(e: any) => setContent(e.target.value)}
                  ></IonInput>
                </IonItem>
                {/* <IonLabel position="floating" className="fs-6">
                  Chọn file
                </IonLabel>
                <IonItem>
                  <input type="file" className="mt-1"></input>
                </IonItem> */}
                <IonItem>
                  <IonLabel position="floating" className="fs-5">
                    Chọn lớp
                  </IonLabel>

                  <IonSelect placeholder="Chọn lớp" onIonChange={(e: any) =>clickClass(e.target.value)}>
                    {classTeacher.map((classTeacher, key) => {
                      return (
                        <IonSelectOption id={classTeacher.id_class_diagram} key={key} value={classTeacher.id_class_diagram}>
                          {classTeacher.name}
                        </IonSelectOption>
                      );
                    })}
                  </IonSelect>
                </IonItem>

                {/* <IonItem>
                  <IonLabel position="floating" className="fs-5">
                    Chọn học sinh
                  </IonLabel>
                  <IonSelect placeholder="Chọn lớp" multiple={true}>
                    <IonSelectOption value="apples">
                      Nguyễn Văn A
                    </IonSelectOption>
                    <IonSelectOption value="oranges">
                      Nguyễn Văn b
                    </IonSelectOption>
                    <IonSelectOption value="bananas">
                      Nguyễn Văn c
                    </IonSelectOption>
                  </IonSelect>
                </IonItem> */}
                <IonButton
                  onClick={addNotificationTeacher}
                  expand="block"
                  className="mt-4"
                >
                  Gửi thông báo
                </IonButton>
              </IonCardContent>
            </IonCard>
          </IonContent>
        </IonModal>
      </IonContent>
    </IonPage>
  );
};

export default NotificationsTeacher;
