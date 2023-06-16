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
  IonFab,
  IonFabList,
  IonFabButton,
  IonIcon,
  IonButton,
  IonModal,
  IonLabel,
  IonInput,
  IonTextarea,
  IonCol,
  IonAccordionGroup,
  IonAccordion,
  IonSelect,
  IonSelectOption,
  IonBackButton,
} from "@ionic/react";
import React, { useEffect, useRef, useState } from "react";
// import { useParams } from 'react-router';
// import ExploreContainer from '../components/ExploreContainer';
import "./Note.css";

import {
  IonItem,
  IonGrid,
  IonRow,
  IonCardHeader,
  IonCardTitle,
  IonCardSubtitle,
  IonSearchbar,
  createAnimation,
} from "@ionic/react";
// import { IonList, IonSelect, IonSelectOption, IonIcon, IonThumbnail } from '@ionic/react';
// import { IonReactRouter } from '@ionic/react-router';
import { Link } from "react-router-dom";
import {
  addCircleOutline,
  chevronUpCircle,
  closeOutline,
  duplicateOutline,
  starSharp,
  trashOutline,
} from "ionicons/icons";
import axios from "axios";

const Opinion: React.FC = () => {
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

  const [note, setNote] = useState([] as any[]);

  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");

    const loginData = {
      token: x,
    };
    api
      .post(`/note_book_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          // if (res.data.subject == null) {
          //   setNote([]);
          // } else {
          setNote(res.data.subject.content);
          // }
        }
      })
      .catch((error) => {});
  }, []);
  const [content, setContent] = useState("");
  function addNote() {
    if (!content) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập ghi chú",
        buttons: ["OK"],
      });
    }
    var x = localStorage.getItem("token");

    const add_score = {
      content: content,
      token: x,
    };

    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    api
      .post("/class_noteBook_teacher", add_score)
      .then((res) => {
        if (res.data.status == "error") {
          dismiss();
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log(res.data.content);
          dismiss();
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

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Ghi chú</IonTitle>
          <IonButton
            slot="end"
            size="small"
            onClick={addNote}
            className="me-3 fw-bold text-primary"
          >
            Lưu
          </IonButton>

          {/* <IonIcon onClick={addNote}
            color="primary"
            slot="end"
            size="large"
            icon={addCircleOutline}
            style={{ marginBottom: 1, marginRight: "20px" }}
          ></IonIcon> */}
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <div className="mt-3 mx-2 mb-4 " style={{ height: "95%" }}>
          <textarea
            className="border border-3 p-3 rounded-3 w-100 h-100"
            // placeholder="Nhập ghi chú"
            defaultValue={note}
            onChange={(e: any) => setContent(e.target.value)}
          ></textarea>
        </div>

        {/* <IonFab slot="fixed" vertical="bottom" horizontal="end">
          <IonFabButton id="open-modal">
            <IonIcon color="success" icon={duplicateOutline}></IonIcon>
          </IonFabButton>
        </IonFab> */}

        {/* <IonModal
          id="example-modal"
          ref={modal}
          trigger="open-modal"
          enterAnimation={enterAnimation}
          leaveAnimation={leaveAnimation}
          style={{ alignItems: "start", marginTop: "20px" }}
        >
          <IonContent>
            <IonToolbar>
              <IonTitle
                color={"white"}
                style={{ textAlign: "center", fontStyle: "bold" }}
              >
                THÊM GHI CHÚ
              </IonTitle>
              <IonButtons slot="end">
                <IonButton onClick={() => dismiss()}>
                  <IonIcon color={"white"} icon={closeOutline}></IonIcon>
                </IonButton>
              </IonButtons>
            </IonToolbar>
            <IonCard color={"light"}>
              <IonCardContent style={{ height: "100%" }}>
                <IonGrid className="py-0">
                  <IonRow className="row align-items-center d-flex">
                    <IonCol>
                      <IonLabel className="lable-name">Lớp :</IonLabel>
                    </IonCol>
                    <IonCol size="8">
                      <div style={{ width: "100%" }}>
                        <IonSelect
                          className="select-name bg-white border border-1"
                          slot="start"
                          interface="popover"
                          placeholder="3A"
                        >
                          <IonSelectOption value="0">Tất cả</IonSelectOption>
                          <IonSelectOption value="1">3A</IonSelectOption>
                          <IonSelectOption value="2">4B</IonSelectOption>
                        </IonSelect>
                      </div>
                    </IonCol>
                  </IonRow>
                </IonGrid>
                <IonGrid className="py-0">
                  <IonRow className="row  align-items-center d-flex">
                    <IonCol>
                      <IonLabel className="lable-name">Học sinh :</IonLabel>
                    </IonCol>
                    <IonCol size="8">
                      <div style={{ width: "100%" }}>
                        <IonSelect
                          className="select-name bg-white border border-1"
                          slot="start"
                          interface="popover"
                          placeholder="Tất cả"
                        >
                          <IonSelectOption value="0">Tất cả</IonSelectOption>
                          <IonSelectOption value="1">
                            Nguyễn Văn A
                          </IonSelectOption>
                          <IonSelectOption value="2">
                            Nguyễn Thị B
                          </IonSelectOption>
                        </IonSelect>
                      </div>
                    </IonCol>
                  </IonRow>
                </IonGrid>
                <IonGrid className="py-0">
                  <IonRow className="row align-items-center d-flex mt-1">
                    <IonCol>
                      <IonLabel className="lable-name">Ngày:</IonLabel>
                    </IonCol>
                    <IonCol className="tt" size="8">
                      <div style={{ width: "90%" }}>
                        <IonInput
                          type="date"
                          class="fw-bold  bg-white border border-1 p-2"
                        ></IonInput>
                      </div>
                    </IonCol>
                  </IonRow>
                </IonGrid>

                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">
                    Tiêu đề ghi chú
                  </IonLabel>
                  <IonInput
                    placeholder="Tiêu đề góp ý"
                    className="ps-2"
                  ></IonInput>
                </IonItem>

                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">
                    Nội dung{" "}
                  </IonLabel>
                  <IonTextarea
                    placeholder="Nội dung góp ý"
                    className="ps-2"
                  ></IonTextarea>

                </IonItem>

                <IonRow
                  class="row-btn"
                  style={{ textAlign: "center", marginTop: "20px" }}
                >
                  <IonCol>
                    <IonButton color="success" style={{ width: "110px" }}>
                      THÊM
                    </IonButton>
                  </IonCol>
                  <IonCol>
                    <IonButton
                      onClick={() => dismiss()}
                      color="danger"
                      style={{ width: "110px" }}
                    >
                      CANCEL
                    </IonButton>
                  </IonCol>
                </IonRow>
              </IonCardContent>
            </IonCard>
          </IonContent>
        </IonModal> */}
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Opinion;
function presentAlert(arg0: {
  header: string;
  message: string;
  buttons: string[];
}) {
  throw new Error("Function not implemented.");
}
