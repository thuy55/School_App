// import { useParams } from "react-router";
import {
  IonCol,
  IonGrid,
  IonRow,
  IonPage,
  IonHeader,
  IonToolbar,
  IonButtons,
  IonMenuButton,
  createAnimation,
  IonTitle,
  IonContent,
  IonLabel,
  IonButton,
  IonModal,
  IonList,
  IonItem,
  IonInput,
  IonTextarea,
  IonFooter,
  IonTabsContext,
  IonTabButton,
  IonIcon,
  IonCardContent,
  IonCardTitle,
  useIonAlert,
  IonBackButton,
} from "@ionic/react";
import { useHistory } from "react-router-dom";
import { useLocation } from "react-router-dom";
import { home, key, library, playCircle, radio, search } from "ionicons/icons";
import "./Account.css";
import React, { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
// import { removeUserSession } from "./Common";
import axios from "axios";
import moment from "moment";

const Account: React.FC = () => {
  const location = useLocation();
  const history = useHistory();
  const handleLogout = () => {
    const removeUserSession = () => {
        localStorage.removeItem('token');
       }
    removeUserSession();
    history.push("/");
  };
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

  const [teacher, setTeacher] = useState([] as any[]);
  const [ma, setMa] = useState([] as any[]);
  const [ethnic, setethnic] = useState([] as any[]);
  const [religion, setreligion] = useState([] as any[]);
  const [regent, setRegent] = useState([] as any[]);
  const [ward, setWard] = useState([] as any[]);
  const [province, setProvince] = useState([] as any[]);
  const [district, setDistrict] = useState([] as any[]);
  const [dateStart, setDateStart] = useState([] as any[]);
  const [nationality, setnationality] = useState([] as any[]);
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
      .post("/teachers/" + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setMa(res.data.id_teacher);
          setTeacher(res.data.teacher);
          setWard(res.data.ward);
          setProvince(res.data.province);
          setDistrict(res.data.district);
          setDateStart(res.data.date);
          setRegent(res.data.regent);
          setethnic(res.data.ethnic);
          setreligion(res.data.religion);
          setnationality(res.data.nationality);
        }
      })
      .catch((error) => {});
  }, []);

  const [passwordold, setPasswordold] = useState("");
  const [password, setPassword] = useState("");
  const [passwordcomfirm, setPasswordcomfirm] = useState("");
  const [message, setMessage] = useState("");
  const [presentAlert] = useIonAlert();
  function changePass() {
    if (!passwordold) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập mật khẩu cũ",
        buttons: ["OK"],
      });
    } else if (!password) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập mật khẩu mới",
        buttons: ["OK"],
      });
    } else if (!passwordcomfirm) {
      presentAlert({
        header: "Lỗi",
        message: "Vui lòng nhập lại mật khẩu mới",
        buttons: ["OK"],
      });
    } else

    if (password != passwordcomfirm) {
      setMessage("Nhập lại mật khẩu mới sai.");
      return;
    } else{
    var x = localStorage.getItem("token");
    const change = {
      passwordold: passwordold,
      password: password,
      passwordcomfirm: passwordcomfirm,
      token: x,
    };

    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    api
      .post("/changepass-teacher", change)
      .then((res) => {
        if (res.data.status == "error") {
          dismiss();
          presentAlert({
            header: "Lỗi",
            message: res.data.content,
            buttons: ["OK"],
          });
        } else if (res.data.status == "success") {
          setMessage("Password changed successfully.");
          setPasswordold("");
          setPassword("");
          setPasswordcomfirm("");
          dismiss();
          presentAlert({
            header: "Thành công",
            message: "Cập nhật mật khẩu thành công",
            buttons: ["OK"],
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

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Thông tin tài khoản</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
        <article className="bg-xl pb-2">
          <div className=" before-bg-style">
            <div className="profile">
              {teacher.map((teacher, key) => {
                return (
                  <div className="avatar">
                    <img
                      className="avatar-img"
                      src={`${teacher.avatar}`}
                      alt=""
                    />
                  </div>
                );
              })}

              <IonCardContent className="bg-3 ms-0 me-0 profile ps-2">
                <IonGrid className="pv mt-4">
                  <IonRow className="align-items-center my-2">
                    <IonCol>Mã giáo viên:</IonCol>
                    <IonCol className="text-1" size="7">
                      <IonInput>{ma}</IonInput>
                    </IonCol>
                  </IonRow>
                  {teacher.map((teacher, key) => {
                    return (
                      <>
                        <IonRow className="align-items-center my-2">
                          <IonCol>Họ và tên:</IonCol>
                          <IonCol className="text-1 text-start" size="7">
                            {teacher.firstname} {teacher.lastname}
                          </IonCol>
                        </IonRow>

                        <IonRow className="align-items-center my-2">
                          <IonCol>Số điện thoại:</IonCol>
                          <IonCol className="text-1" size="7">
                            {teacher.phone_number}
                          </IonCol>
                        </IonRow>

                        <IonRow className="align-items-center my-2">
                          <IonCol>Ngày sinh:</IonCol>
                          <IonCol className="text-1" size="7">
                            {moment(teacher.birthday).format("DD-MM-YYYY")}
                          </IonCol>
                        </IonRow>

                        <IonRow className="align-items-center my-2">
                          <IonCol>Giới tính :</IonCol>
                          <IonCol className="text-1" size="7">
                            {teacher.gender}
                          </IonCol>
                        </IonRow>
                        <IonRow className="align-items-center my-2">
                          <IonCol>Học hàm :</IonCol>
                          <IonCol className="text-1" size="7">
                            {teacher.academic_function}
                          </IonCol>
                        </IonRow>
                      </>
                    );
                  })}
                  {regent.map((regent, key) => {
                    return (
                      <IonRow className="align-items-center my-2">
                        <IonCol>Chức vụ:</IonCol>
                        <IonCol className="text-1" size="7">
                          {regent.name}
                        </IonCol>
                      </IonRow>
                    );
                  })}

                  <IonRow className="align-items-center my-2">
                    <IonCol>Ngày bắt đầu:</IonCol>
                    <IonCol className="text-1" size="7">
                      {moment(dateStart).format("DD-MM-YYYY")}
                    </IonCol>
                  </IonRow>

                  <IonRow className="align-items-center my-2">
                    <IonCol>Dân tộc :</IonCol>
                    <IonCol className="text-1" size="7">
                      {ethnic}
                    </IonCol>
                  </IonRow>
                  <IonRow className="align-items-center my-2">
                    <IonCol>Tôn giáo :</IonCol>
                    <IonCol className="text-1" size="7">
                      {religion}
                    </IonCol>
                  </IonRow>

                  <IonRow className="align-items-center my-2">
                    <IonCol>Quốc tịch :</IonCol>
                    <IonCol className="text-1" size="7">
                      {nationality}
                    </IonCol>
                  </IonRow>
                  {teacher.map((teacher, key) => {
                    return (
                      <IonRow className="align-items-center my-2">
                        <IonCol>Email:</IonCol>
                        <IonCol className="text-1" size="7">
                          {teacher.email}
                        </IonCol>
                      </IonRow>
                    );
                  })}
                  {teacher.map((teacher, key) => {
                    return (
                      <IonRow className="align-items-center my-2">
                        <IonCol>Địa chỉ:</IonCol>
                        <IonCol className="text-1" size="7">
                          {teacher.address} {ward} {district} {province}
                          {/* <IonTextarea value="54 Bàu Cát 6, phường 14, Tân Bình, tpHCM"></IonTextarea> */}
                        </IonCol>
                      </IonRow>
                    );
                  })}
                </IonGrid>
              </IonCardContent>
            </div>
          </div>
        </article>

        <IonRow className="justify-content-center mt-2 d-flex">
          <IonButton
            className="w-75"
            color="tertiary"
            id="open-modal-repass"
            expand="block"
          >
            ĐỔI MẬT KHẨU
          </IonButton>
          <IonModal
            id="example-modal"
            ref={modal}
            trigger="open-modal-repass"
            enterAnimation={enterAnimation}
            leaveAnimation={leaveAnimation}
          >
            <IonContent>
              <IonToolbar>
                <IonTitle className="text-center">Đổi mật khẩu</IonTitle>
                <IonButtons slot="end">
                  <IonButton onClick={() => dismiss()}>X</IonButton>
                </IonButtons>
              </IonToolbar>
              <IonList className="p-3">
                <IonLabel>Nhập mật khẩu cũ :</IonLabel>
                <IonItem fill="outline" className="mt-2 mb-3">
                  <IonInput
                    className="ps-3"
                    id="passwordold"
                    type="password"
                    placeholder="******"
                    onIonChange={(e: any) => setPasswordold(e.target.value)}
                  ></IonInput>
                </IonItem>
                <IonLabel>Nhập mật khẩu mới :</IonLabel>
                <IonItem fill="outline" className="mt-2 mb-3">
                  <IonInput
                    className="ps-3"
                    type="password"
                    placeholder="******"
                    onIonChange={(e: any) => setPassword(e.target.value)}
                  ></IonInput>
                </IonItem>
                <IonLabel>Nhập lại mật khẩu mới :</IonLabel>
                <IonItem fill="outline" className="mt-2 mb-3">
                  <IonInput
                    className="ps-3"
                    type="password"
                    placeholder="******"
                    onIonChange={(e: any) => setPasswordcomfirm(e.target.value)}
                  ></IonInput>
                </IonItem>

                <IonRow
                  class="row-btn"
                  style={{ textAlign: "center", marginTop: "20px" }}
                >
                  <IonCol>
                    <IonButton
                      onClick={changePass}
                      color="tertiary"
                      style={{ width: "110px" }}
                    >
                      CẬP NHẬT
                    </IonButton>
                  </IonCol>
                  <IonCol>
                    <IonButton
                      onClick={() => dismiss()}
                      color="dark"
                      style={{ width: "110px" }}
                    >
                      HUỶ
                    </IonButton>
                  </IonCol>
                </IonRow>
              </IonList>
            </IonContent>
          </IonModal>
        </IonRow>
        <IonRow className="justify-content-center mt-2 pb-4 d-flex">
          <IonButton className="w-75" color="dark" onClick={handleLogout}>
            ĐĂNG XUẤT
          </IonButton>
        </IonRow>
      </IonContent>

      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Account;
