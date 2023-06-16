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
  IonToast,
  IonButton,
  useIonAlert,
} from "@ionic/react";

// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Debt.css";
import { useEffect, useRef, useState } from "react";
import axios from "axios";
import moment from "moment";

const Leave: React.FC = () => {
  const [leave, setLeave] = useState([] as any[]);
  const [showToast, setShowToast] = useState(false);

  useEffect(() => {
    console.log("vvvv");
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
      .post(`/furlough_announcement_teacher`, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          console.log("aaaaaaaa");
          if (res.data.furlough == null) {
            setShowToast(true);
            setLeave([]);
          } else {
            setLeave(res.data.furlough);
          }
        }
      })
      .catch((error) => {});
  }, []);

  function infoleave(e: any) {
    const id = e.target.id;
    localStorage.setItem("id_leave", id);
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    console.log("ccccccc", id);
    var x = localStorage.getItem("token");
    const loginData = {
      token: x,
    };
    api
      .post(`/furlough_announcement_detail_teacher/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          console.log("bbbbb");
        }
      })
      .catch((error) => {});
  }
  const [presentAlert] = useIonAlert();
  function duyet() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_leave = localStorage.getItem("id_leave");
    const loginData = {
      token: x,
    };
    api
      .post(`/furlough_browser_teacher/` + id_leave, loginData)
      .then((res) => {
        if (res.data.status == "error") {
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log(res.data.content);
          window.location.reload();
        }
      })
      .catch((error) => {
        presentAlert({
          header: "Lỗi",
          message: "không thể kết nối đến máy chủ",
          buttons: ["OK"],
        });
      });
  }

  function tuchoi() {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_leave = localStorage.getItem("id_leave");
    const loginData = {
      token: x,
    };
    api
      .post(`/furlough__delete_browser_teacher/` + id_leave, loginData)
      .then((res) => {
        if (res.data.status == "error") {
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          console.log(res.data.content);
          window.location.reload();
        }
      })
      .catch((error) => {
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
            <IonMenuButton />
            {/* <IonBackButton></IonBackButton> */}
          </IonButtons>
          <IonTitle>Danh sách xin nghỉ phép</IonTitle>
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
          {leave.map((leave, key) => {
            if (leave.statu == "Đã duyệt") {
              return (
                <IonAccordion
                  value={leave.id}
                  className="mt-3 acc"
                  onClick={infoleave}
                  key={key}
                  id={leave.id}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash ps-0"
                    onClick={infoleave}
                    key={leave.id}
                    id={leave.id}
                  >
                    <div
                      className="item-count ms-2 bg-success"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      P
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      Học sinh: {leave.firstname_student}{" "}
                      {leave.lastname_student}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        <IonCol
                          className="ps-0"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <p
                            className="text-secondary"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            Số ngày nghỉ : {leave.numberday}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-end"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <h6
                            className="text-danger"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            {moment(leave.datecurrent).format("DD-MM-YYYY")}
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
                                    Học sinh :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.firstname_student}{" "}
                                  {leave.lastname_student}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Số ngày :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.numberday}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Bắt đầu :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.date_start}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Kết thúc:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.date_end}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Lý do:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.reason}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Trạng thái:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.statu}
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
            } else if (leave.statu == "Từ chối") {
              return (
                <IonAccordion
                  value={leave.id}
                  className="mt-3 acc"
                  onClick={infoleave}
                  key={key}
                  id={leave.id}
                >
                  <IonItem
                    slot="header"
                    color="red"
                    className="item-Cash ps-0"
                    onClick={infoleave}
                    key={leave.id}
                    id={leave.id}
                  >
                    <div
                      className="item-count ms-2 bg-danger"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      K
                    </div>
                    <IonLabel
                      className="fw-bold"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      Học sinh: {leave.firstname_student}{" "}
                      {leave.lastname_student}
                      <IonRow
                        className="d-flex align-items-center w-100 mt-2"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        <IonCol
                          className="ps-0"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <p
                            className="text-secondary"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            Số ngày nghỉ : {leave.numberday}
                          </p>
                        </IonCol>
                        <IonCol
                          className="text-end"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <h6
                            className="text-danger"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            {moment(leave.datecurrent).format("DD-MM-YYYY")}
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
                                    Học sinh :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.firstname_student}{" "}
                                  {leave.lastname_student}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Số ngày :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.numberday}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Bắt đầu :
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.date_start}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Kết thúc:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.date_end}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Lý do:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.reason}
                                </IonCol>
                              </IonRow>
                            </p>
                          </li>
                          <li>
                            <p className="link">
                              <IonRow className="row text-align-center">
                                <IonCol>
                                  <IonLabel className="lable-name">
                                    Trạng thái:
                                  </IonLabel>
                                </IonCol>
                                <IonCol size="8" className="nd">
                                  {leave.statu}
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
              if (leave.view == 0) {
                return (
                  <IonAccordion
                    value={leave.id}
                    className="mt-3 acc"
                    onClick={infoleave}
                    key={key}
                    id={leave.id}
                  >
                    <IonItem
                      slot="header"
                      color="red"
                      className="item-Cash ps-0"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      <div
                        className="item-count ms-2 bg-warning"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        C
                      </div>
                      <IonLabel
                        className="fw-bold"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        Học sinh: {leave.firstname_student}{" "}
                        {leave.lastname_student}
                        <IonRow
                          className="d-flex align-items-center w-100 mt-2"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <IonCol
                            className="ps-0"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            <p
                              className="text-secondary"
                              onClick={infoleave}
                              key={leave.id}
                              id={leave.id}
                            >
                              Số ngày nghỉ : {leave.numberday}
                            </p>
                          </IonCol>
                          <IonCol
                            className="text-end"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            <h6
                              className="text-danger"
                              onClick={infoleave}
                              key={leave.id}
                              id={leave.id}
                            >
                              {moment(leave.datecurrent).format("DD-MM-YYYY")}
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
                                      Học sinh :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.firstname_student}{" "}
                                    {leave.lastname_student}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Số ngày :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.numberday}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Bắt đầu :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.date_start}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Kết thúc:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.date_end}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Lý do:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.reason}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Trạng thái:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.statu}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                          </ol>
                        </li>
                      </ol>
                      <IonRow className="d-flex justify-content-center mb-2">
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75 "
                            color={"danger"}
                            onClick={tuchoi}
                          >
                            TỪ CHỐI
                          </IonButton>
                        </IonCol>
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75"
                            color={"success"}
                            onClick={duyet}
                          >
                            DUYỆT
                          </IonButton>
                        </IonCol>
                      </IonRow>
                    </div>
                  </IonAccordion>
                );
              } else {
                return (
                  <IonAccordion
                    value={leave.id}
                    className="mt-3 acc"
                    onClick={infoleave}
                    key={key}
                    id={leave.id}
                  >
                    <IonItem
                      slot="header"
                      color="red"
                      className="item-Cash11 ps-0"
                      onClick={infoleave}
                      key={leave.id}
                      id={leave.id}
                    >
                      <div
                        className="item-count ms-2 bg-warning"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        C
                      </div>
                      <IonLabel
                        className="fw-bold"
                        onClick={infoleave}
                        key={leave.id}
                        id={leave.id}
                      >
                        Học sinh: {leave.firstname_student}{" "}
                        {leave.lastname_student}
                        <IonRow
                          className="d-flex align-items-center w-100 mt-2"
                          onClick={infoleave}
                          key={leave.id}
                          id={leave.id}
                        >
                          <IonCol
                            className="ps-0"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            <p
                              className="text-secondary"
                              onClick={infoleave}
                              key={leave.id}
                              id={leave.id}
                            >
                              Số ngày nghỉ : {leave.numberday}
                            </p>
                          </IonCol>
                          <IonCol
                            className="text-end"
                            onClick={infoleave}
                            key={leave.id}
                            id={leave.id}
                          >
                            <h6
                              className="text-danger"
                              onClick={infoleave}
                              key={leave.id}
                              id={leave.id}
                            >
                              {moment(leave.datecurrent).format("DD-MM-YYYY")}
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
                                      Học sinh :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.firstname_student}{" "}
                                    {leave.lastname_student}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Số ngày :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.numberday}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Bắt đầu :
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.date_start}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Kết thúc:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.date_end}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Lý do:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.reason}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                            <li>
                              <p className="link">
                                <IonRow className="row text-align-center">
                                  <IonCol>
                                    <IonLabel className="lable-name">
                                      Trạng thái:
                                    </IonLabel>
                                  </IonCol>
                                  <IonCol size="8" className="nd">
                                    {leave.statu}
                                  </IonCol>
                                </IonRow>
                              </p>
                            </li>
                          </ol>
                        </li>
                      </ol>
                      <IonRow className="d-flex justify-content-center mb-2">
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75 "
                            color={"danger"}
                            onClick={tuchoi}
                          >
                            TỪ CHỐI
                          </IonButton>
                        </IonCol>
                        <IonCol className="d-flex justify-content-center">
                          <IonButton
                            className="fw-bold w-75"
                            color={"success"}
                            onClick={duyet}
                          >
                            DUYỆT
                          </IonButton>
                        </IonCol>
                      </IonRow>
                    </div>
                  </IonAccordion>
                );
              }
            }
          })}
        </IonAccordionGroup>
      </IonContent>
    </IonPage>
  );
};

export default Leave;
