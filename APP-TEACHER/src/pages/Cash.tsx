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
  IonCard,
  IonCardContent,
  IonGrid,
  IonSelect,
  IonSelectOption,
  IonInput,
  IonTextarea,
  IonButton,
  IonIcon,
  IonFab,
  IonFabButton,
  IonModal,
  createAnimation,
  useIonAlert,
  IonToast,
} from "@ionic/react";
import {
  addOutline,
  closeOutline,
} from "ionicons/icons";
import { useEffect, useRef, useState } from "react";

import "./Cash.css";
import axios from "axios";
import moment from "moment";

const Cash: React.FC = () => {
  const modal = useRef<HTMLIonModalElement>(null);

  const [presentAlert] = useIonAlert();
  const [title, setTitle] = useState("");
  const [price, setPrice] = useState("");
  const [content, setContent] = useState("");

  const [classFund, setClassFund] = useState([] as any[]);
  const [revenueExpenditure, setRevenueExpenditure] = useState([] as any[]);
  const [total, setTotal] = useState(0);
  const [total2, setTotal2] = useState(0);
  const [monthYear, setMonthYear] = useState([] as any[]);
  const [sum1, setSum1] = useState([] as any[]);
  const [sum2, setSum2] = useState([] as any[]);

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
  const [showToast, setShowToast] = useState(false);
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
      .post(`/class_fund_book_teacher/` + id, loginData)
      .then((res) => {
        setMonthYear(res.data.month_year);
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setClassFund([]);
            setSum1([]);
          } else {
            const i = res.data.month_year;
            localStorage.setItem("month", i);
            setClassFund(res.data.content);
            setSum1(res.data.sum);
          }
        }
      })
      .catch((error) => {});
  }, []);

  function getMonth(e: any) {
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
      .post(`/class_fund_book_click_teacher/` + e, loginData)
      .then((res) => {
        setMonthYear(res.data.month_year);
        if (res.data.status == "success") {
          if (res.data.thu == null) {
            setShowToast(true);
            localStorage.removeItem("month");
            localStorage.setItem("month", e);
            setClassFund([]);
            setSum1([]);
          } else if (res.data.chi == null) {
            setShowToast(true);
            localStorage.removeItem("month");
            localStorage.setItem("month", e);
            setRevenueExpenditure([]);
            setSum2([]);
          } else {
            localStorage.removeItem("month");
            localStorage.setItem("month", e);
            setClassFund(res.data.thu);
            setRevenueExpenditure(res.data.chi);
            setSum1(res.data.sum1);
            setSum2(res.data.sum2);
          }
        }
      })
      .catch((error) => {});
  }

  function getRevenueExpenditure(e: any) {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_school_teacher");
    var month = localStorage.getItem("month");
    var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
      id_school_teacher: id,
      id_course: id_course,
    };
    api
      .post(`/revenue_expenditure_teacher/` + month, loginData)
      .then((res) => {
        setMonthYear(res.data.month_year);
        if (res.data.status == "success") {
          if (res.data.content == null) {
            setShowToast(true);
            setRevenueExpenditure([]);
            setSum2([]);
          } else {
            // localStorage.removeItem("month");
            // localStorage.setItem("month", e);
            setRevenueExpenditure(res.data.content);
            setSum2(res.data.sum);
          }
        }
      })
      .catch((error) => {});
  }

  function clickCash(e: any) {
    localStorage.removeItem("type");
    localStorage.setItem("type", e);
  }

  //Add thu chi

  function addCash() {
    var type = localStorage.getItem("type");

    if (!title) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập nội dung",
        buttons: ["OK"],
      });
    } else if (!price) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập số tiền",
        buttons: ["OK"],
      });
    } else {
      var id = localStorage.getItem("id_school_teacher");
      var x = localStorage.getItem("token");
      var id_course = localStorage.getItem("id_course");
      const add_cash = {
        title: title,
        price: price,
        content: content,
        type: type,
        token: x,
        id_school_teacher: id,
        id_course: id_course,
      };

      const api = axios.create({
        baseURL: "https://school.hewo.vn/api",
      });
      api
        .post("/class_fund_book_add_teacher/" + type, add_cash)
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

            window.location.reload();
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
          <IonButtons slot="start">
            <IonMenuButton />
          </IonButtons>
          <IonTitle>Sổ thu chi</IonTitle>
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
        <IonCard className="card-home-cash">
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              <IonRow className="row px-5 align-items-center d-flex">
                <IonCol>
                  <IonLabel className="lable-name">Tháng :</IonLabel>
                </IonCol>
                <IonCol size="8">
                  <div style={{ width: "100%" }}>
                    <IonInput
                      type="month"
                      className="bg-white p-1"
                      onIonChange={(e: any) => getMonth(e.target.value)}
                    ></IonInput>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>

        <div className="card border-0 border-top mt-3">
          <div className="card-header">
            <ul
              className="nav nav-pills  d-flex justify-content-around"
              id="pills-tab"
              role="tablist"
            >
              <li className="nav-item" role="presentation">
                <button
                  className="nav-link active"
                  id="pills-home-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-thu"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true"
                >
                  Quỹ lớp
                </button>
              </li>
              <li className="nav-item" role="presentation">
                <button
                  onClick={getRevenueExpenditure}
                  className="nav-link"
                  id="pills-profile-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#nav-chi"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected="false"
                >
                  Chi tiêu
                </button>
              </li>
            </ul>
          </div>
          <form className="card-body tab-content px-2">
            <div className="tab-pane active" id="nav-thu">
              <IonLabel className="fw-bold text-end">
                <p>
                  Tổng tiền chi {moment(monthYear).format("MM-YYYY")}: {sum1}{" "}
                  VNĐ{" "}
                </p>
              </IonLabel>
              {classFund.map((classFund, key) => {
                return (
                  <IonAccordionGroup className="mt-3 mx-2">
                    <IonAccordion
                      value={`${classFund.id}`}
                      className="mt-3 acc"
                    >
                      <IonItem slot="header" color="red" className="item-Cash">
                        <div className="item-count bg-color-green">T</div>
                        <IonLabel className="fw-bold">
                          {classFund.title}
                          <p className="mt-2 text-secondary">
                            Số tiền: {classFund.price} VND
                          </p>
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
                                        Nội dung:
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {classFund.content}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                              <li>
                                <p className="link">
                                  <IonRow className="row text-align-center">
                                    <IonCol>
                                      <IonLabel className="lable-name">
                                        Số tiền :
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {classFund.price} VND
                                    </IonCol>
                                  </IonRow>{" "}
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
                                      {moment(classFund.date).format(
                                        "DD-MM-YYYY"
                                      )}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                              <li>
                                <p className="link">
                                  <IonRow className="row text-align-center">
                                    <IonCol>
                                      <IonLabel className="lable-name">
                                        Ghi chú:
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {classFund.status}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                            </ol>
                          </li>
                        </ol>
                      </div>
                    </IonAccordion>
                  </IonAccordionGroup>
                );
              })}
            </div>
            <div className="tab-pane" id="nav-chi">
              <IonLabel className="fw-bold text-end">
                <p>
                  Tổng tiền chi {moment(monthYear).format("MM-YYYY")}: {sum2}{" "}
                  VNĐ{" "}
                </p>
              </IonLabel>
              {revenueExpenditure.map((revenueExpenditure, key) => {
                return (
                  <IonAccordionGroup className="mt-3 mx-2">
                    <IonAccordion value={`${revenueExpenditure.id}`} className="mt-3 acc">
                      <IonItem slot="header" color="red" className=" item-Cash">
                        <div className="item-count bg-color-green">C</div>
                        <IonLabel className="fw-bold">
                          {revenueExpenditure.content}
                          <p className="mt-2 text-secondary">
                            Số tiền: {revenueExpenditure.price} VND
                          </p>
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
                                        Nội dung:
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {revenueExpenditure.content}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                              <li>
                                <p className="link">
                                  <IonRow className="row text-align-center">
                                    <IonCol>
                                      <IonLabel className="lable-name">
                                        Số tiền :
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {revenueExpenditure.price} VND
                                    </IonCol>
                                  </IonRow>{" "}
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
                                      {moment(revenueExpenditure.date).format(
                                        "DD-MM-YYYY"
                                      )}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                              <li>
                                <p className="link">
                                  <IonRow className="row text-align-center">
                                    <IonCol>
                                      <IonLabel className="lable-name">
                                        Ghi chú:
                                      </IonLabel>
                                    </IonCol>
                                    <IonCol size="8" className="nd">
                                      {revenueExpenditure.status}
                                    </IonCol>
                                  </IonRow>
                                </p>
                              </li>
                            </ol>
                          </li>
                        </ol>
                      </div>
                    </IonAccordion>
                  </IonAccordionGroup>
                );
              })}
            </div>
          </form>
        </div>
        <IonFab slot="fixed" vertical="bottom" horizontal="end">
          <IonFabButton id="open-modal-thuchi">
            <IonIcon size="large" icon={addOutline}></IonIcon>
          </IonFabButton>
          {/* <IonFabList side="top">
            <IonFabButton >
              <IonIcon color="success" icon={duplicateOutline}></IonIcon>
            </IonFabButton>
            <IonFabButton>
              <IonIcon color="danger" icon={trashOutline}></IonIcon>
            </IonFabButton>
          </IonFabList> */}
        </IonFab>

        <IonModal
          id="example-modal"
          ref={modal}
          trigger="open-modal-thuchi"
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
                THÊM THU CHI
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
                  <IonRow className="me-2 d-flex align-items-center ms-2">
                    <IonCol>
                      <IonLabel className="lable-name">
                        <p>Chọn mục thu/chi:</p>
                      </IonLabel>
                    </IonCol>
                    <IonCol size="6">
                      <div style={{ width: "100%" }}>
                        <IonSelect
                          className="select-name bg-white border border-2"
                          slot="start"
                          interface="popover"
                          placeholder="Thu"
                          onIonChange={(e: any) => clickCash(e.target.value)}
                        >
                          <IonSelectOption value="1">Thu</IonSelectOption>
                          <IonSelectOption value="2">Chi</IonSelectOption>
                        </IonSelect>
                      </div>
                    </IonCol>
                  </IonRow>
                </IonGrid>
                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">
                    Nội dung thu chi
                  </IonLabel>{" "}
                  <IonTextarea
                    placeholder="Nhập nội dung thu chi"
                    className="ps-2"
                    onIonChange={(e: any) => setTitle(e.target.value)}
                  ></IonTextarea>
                </IonItem>
                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">
                    Số tiền
                  </IonLabel>
                  <IonInput
                    placeholder="Nhập số tiền"
                    className="ps-2"
                    onIonChange={(e: any) => setPrice(e.target.value)}
                  ></IonInput>
                </IonItem>

                <IonItem
                  fill="outline"
                  style={{ width: "100%", marginTop: "20px" }}
                >
                  <IonLabel position="floating" className="ps-2">
                    Ghi chú
                  </IonLabel>
                  <IonTextarea
                    placeholder="Nội dung ghi chú"
                    className="ps-2"
                    onIonChange={(e: any) => setContent(e.target.value)}
                  ></IonTextarea>
                </IonItem>

                <IonRow
                  class="row-btn"
                  style={{ textAlign: "center", marginTop: "20px" }}
                >
                  <IonCol>
                    <IonButton
                      color="success"
                      style={{ width: "110px" }}
                      onClick={addCash}
                    >
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
        </IonModal>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Cash;
