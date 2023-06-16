import {
  IonAccordion,
  IonAccordionGroup,
  IonBackButton,
  IonButton,
  IonButtons,
  IonCard,
  IonCardContent,
  IonCol,
  IonContent,
  IonFab,
  IonFabButton,
  IonGrid,
  IonHeader,
  IonIcon,
  IonInput,
  IonItem,
  IonLabel,
  IonMenuButton,
  IonModal,
  IonPage,
  IonRow,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
  IonTextarea,
  IonTitle,
  IonToast,
  IonToolbar,
  createAnimation,
  useIonAlert,
} from "@ionic/react";
import { addOutline, camera, closeOutline, starSharp } from "ionicons/icons";
import { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
import { saveAs } from "file-saver";

import "./LessionPlan.css";
import axios from "axios";
import moment from "moment";

const OpinionDetail: React.FC = () => {
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

  const [plan, setPlan] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    const loginData = {
      token: x,
    };
    api
      .post("/file_lesson_plan_teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setPlan(res.data.lesson_plan);
        }
      })
      .catch((error) => {});
  }, []);

  function clickFile(id: any, file:any, name:any) {
    // const item = e.target.id;
    // const fileurl= e.target.key;
    localStorage.removeItem("id");
    localStorage.setItem("id", id);
    localStorage.removeItem("url");
    localStorage.setItem("url", file);
    localStorage.removeItem("namefile");
    localStorage.setItem("namefile", name);
  }
  const [showToast, setShowToast] = useState(false);
  function deletePlan() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id");
    const loginData = {
      token: x,
    };
    api
      .post(`/delete_file_lesson_plan_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "error") {
          console.log("aaaaaaa");
          dismiss();
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log("bbbbbbb");
          setShowToast(true);
          // console.log(res.data.content);
          // dismiss();
          window.location.reload();
        }
      })
      .catch((error) => {
        console.log("không chạy api dc");
        dismiss();
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
  }

  const [presentAlert] = useIonAlert();
  const [title, setTitle] = useState("");
  const [avatar, setAvatar] = useState("");
  
  function addPlan() {
    // var avatar= localStorage.getItem("avatar");

    var x = localStorage.getItem("token");
    if (!title) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập tiêu đề",
        buttons: ["OK"],
      });
    } else if (!avatar) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng chọn file",
        buttons: ["OK"],
      });
    } else {
      let formData = new FormData();
      formData.append("file", avatar);
      // var test2 = formData.append("title", title);
      // formData.append('token', x);

      // const add_plan = {
      //   token: x,
      //   title: test2,
      //   avatar: test1,
      // };

      const api = axios.create({
        baseURL: "https://dev.school.hewo.vn",
      });

      api
        .post("/upload", formData)
        .then((res) => {
          if (res.data.status == "error") {
            console.log("aaaaaaa");
          } else if (res.data.status == "success") {
            // console.log(res.data.content);
            // dismiss();
            // window.location.reload();
            console.log(res.data.data);
            const add_plan = {
              token: x,
              title: title,
              avatar: res.data.data,
            };
            const api2 = axios.create({
              baseURL: "https://school.hewo.vn/api",
            });
            api2
              .post("/add_file_lesson_plan_teacher", add_plan)
              .then((res) => {
                if (res.data.status == "error") {
                  console.log("aaaaaaa");
                  dismiss();
                  presentAlert({
                    header: "Lỗi",
                    message: res.data.content,
                    buttons: ["OK"],
                  });
                } else if (res.data.status == "success") {
                  // console.log(res.data.content);
                  dismiss();
                  window.location.reload();
                  console.log("bbbbbbb");
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

  // const [fileUrl, setFileUrl] = useState();

  // function downloadFile() {
  function downloadFile() {
    const file= localStorage.getItem("url");
    var fileName= localStorage.getItem("namefile");


    const link = document.createElement('a');
    link.href = String(file);
    link.download = String(fileName);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };


  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
            {/* <IonBackButton></IonBackButton> */}
          </IonButtons>
          <IonTitle>Giáo án dạy học</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonToast
          isOpen={showToast}
          message="Xóa giáo án thành công."
          duration={3000}
          onDidDismiss={() => setShowToast(false)}
          position="top"
          color="primary"
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
        <IonAccordionGroup className="mt-2 p-2">
          {plan.map((plan, key) => {
            return (
              <IonAccordion value={plan.id} className="p-1 bg-color  mb-2">
                <IonItem
                  slot="header"
                  color="red"
                  className="item-lession"
                  // onClick={clickFile}
                  onClick={(event) => {
                    clickFile(plan.id, plan.file, plan.name);
                  }}
                  // id={plan.id}
                  // key={plan.file}
                >
                  <IonIcon
                    icon={starSharp}
                    className="m-4"
                    onClick={(event) => {
                      clickFile(plan.id, plan.file, plan.name);
                    }}
                  ></IonIcon>

                  <IonLabel
                    className="name"
                    onClick={(event) => {
                      clickFile(plan.id, plan.file, plan.name);
                    }}
                  >
                    Tiêu đề: {plan.title}
                    <p
                      className="mt-2 text-secondary fw-medium"
                      onClick={(event) => {
                        clickFile(plan.id, plan.file, plan.name);
                      }}
                    >
                      File: {plan.name}
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="" slot="content">
                  <IonCard className="bg-card">
                    <IonCardContent className="card-content-grid-list px-2">
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="title-name">Link file:</IonLabel>
                        </IonCol>
                        <IonCol size="9" className="noidung">
                          {plan.file}
                        </IonCol>
                      </IonRow>
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="title-name">Ngày:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="9">
                          <h5>{moment(plan.date_post).format("DD-MM-YYYY")}</h5>
                        </IonCol>
                      </IonRow>
                    </IonCardContent>
                  </IonCard>
                  <IonRow className=" mt-1">
                    <IonCol className="justify-content-center d-flex">
                      <IonButton
                        size="small"
                        color={"warning"}
                        className="fw-bold w-75"
                        expand="block"
                        onClick={deletePlan}
                      >
                        Xóa
                      </IonButton>
                    </IonCol>
                    <IonCol className="justify-content-center d-flex">
                      <IonButton
                        size="small"
                        color={"warning"}
                        className="fw-bold w-75"
                        onClick={downloadFile}
                        id={plan.file}
                      >
                        Tải xuống
                      </IonButton>
                    </IonCol>
                  </IonRow>
                </div>
              </IonAccordion>
            );
          })}
        </IonAccordionGroup>
        {/* </IonGrid> */}
      </IonContent>
     
      <IonFab slot="fixed" vertical="bottom" horizontal="end">
        <IonFabButton id="open-modal-add">
          <IonIcon color="light" icon={addOutline}></IonIcon>
        </IonFabButton>
      </IonFab>

      <IonModal
        id="example-modal"
        ref={modal}
        trigger="open-modal-add"
        enterAnimation={enterAnimation}
        leaveAnimation={leaveAnimation}
        style={{ alignItems: "start", marginTop: "20px" }}
        className="h-50"
      >
        <IonContent>
          <IonToolbar>
            <IonTitle
              color={"white"}
              style={{ textAlign: "center", fontStyle: "bold" }}
            >
              THÊM GIÁO ÁN
            </IonTitle>
            <IonButtons slot="end">
              <IonButton onClick={() => dismiss()}>
                <IonIcon color={"white"} icon={closeOutline}></IonIcon>
              </IonButton>
            </IonButtons>
          </IonToolbar>
          <form encType="multipart/form-data">
            <IonCard color={"light"}>
              <IonCardContent style={{ height: "100%" }}>
                <IonLabel position="floating" className="ps-2">
                  Tiêu đề:
                </IonLabel>
                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "10px" }}
                >
                  <IonInput
                    placeholder="Tiêu đề"
                    className="ps-2"
                    onIonChange={(e: any) => setTitle(e.target.value)}
                  ></IonInput>
                </IonItem>

                <IonLabel className="text-center d-flex mt-4 ps-2">
                  Vui lòng chọn tệp tin:
                </IonLabel>
                <div className="input-group">
                  <input
                    type="file"
                    className="form-control p-2"
                    id="inputGroupFile04"
                    aria-describedby="inputGroupFileAddon04"
                    aria-label="Upload"
                    accept="*"
                    onChange={(e: any) => setAvatar(e.target.files[0])}
                  />
                </div>

                <IonRow
                  class="row-btn"
                  style={{ textAlign: "center", marginTop: "20px" }}
                >
                  <IonCol>
                    <IonButton
                      onClick={() => dismiss()}
                      color="danger"
                      style={{ width: "110px" }}
                    >
                      CANCEL
                    </IonButton>
                  </IonCol>
                  <IonCol>
                    <IonButton
                      color="success"
                      style={{ width: "110px" }}
                      onClick={addPlan}
                    >
                      Thêm
                    </IonButton>
                  </IonCol>
                </IonRow>
              </IonCardContent>
            </IonCard>
          </form>
        </IonContent>
      </IonModal>
    </IonPage>
  );
};

export default OpinionDetail;
