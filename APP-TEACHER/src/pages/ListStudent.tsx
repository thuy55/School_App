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
  IonGrid,
  IonHeader,
  IonIcon,
  IonImg,
  IonInput,
  IonItem,
  IonLabel,
  IonMenuButton,
  IonPage,
  IonRow,
  IonSearchbar,
  IonSelect,
  IonSelectOption,
  IonTitle,
  IonToast,
  IonToolbar,
} from "@ionic/react";
import { starSharp } from "ionicons/icons";
import { Link } from "react-router-dom";

import "./ListStudent.css";
import { useEffect, useState } from "react";
import axios from "axios";
import moment from "moment";

const OpinionDetail: React.FC = () => {
  const [grade, setGrade] = useState([] as any[]);
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
      .post("/grade/" + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setGrade(res.data.grade);
        }
      })
      .catch((error) => {});
  }, []);
  const [showToast, setShowToast] = useState(false);
  const [clas, setClas] = useState([] as any[]);
  function getClass(e: any) {
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
      .post(`/class_teacher_full/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.class == null) {
            setShowToast(true);
            setClas([]);
          } else {
            localStorage.setItem("id_grade", e);
            // localStorage.removeItem("id_class");
            setClas(res.data.class);
          }
        }
      })
      .catch((error) => {});
  }
  const [listStudent, setListStudent] = useState([] as any[]);
  function getListStudents(e: any) {
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
      .post(`/student-teacher-list/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.liststudent == null) {
            setShowToast(true);
            setListStudent([]);
          } else {
            localStorage.setItem("id_class", e);
            // localStorage.removeItem("id_grade");
            setListStudent(res.data.liststudent);
          }
        }
      })
      .catch((error) => {});
  }

  function handleItemClick(event: any) {
    const itemId = event.target.id;
    localStorage.removeItem("id_student");
    localStorage.setItem("id_student", itemId);
    console.log(itemId);
  }

  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Danh sách học sinh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        {/* <IonGrid style={{ marginTop: "10px" }}> */}
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

        <IonCard className="card-home">
          <IonCardContent className="card-content">
            <IonGrid className="py-0">
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Khối :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <IonSelect
                      className="select-name"
                      color="primary"
                      slot="start"
                      interface="popover"
                      placeholder="Chọn khối"
                      onIonChange={(e: any) => getClass(e.target.value)}
                    >
                      {grade.map((grade, key) => {
                        return (
                          <IonSelectOption key={key} value={grade.id}>
                            {grade.name}
                          </IonSelectOption>
                        );
                      })}
                    </IonSelect>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>

            <IonGrid className="py-0">
              <IonRow className="me-2 d-flex align-items-center ms-2">
                <IonCol>
                  <IonLabel className="lable-name">Lớp :</IonLabel>
                </IonCol>
                <IonCol size="9">
                  <div style={{ width: "100%" }}>
                    <IonSelect
                      className="select-name"
                      color="primary"
                      slot="start"
                      interface="popover"
                      placeholder="Chọn lớp"
                      onIonChange={(e: any) => getListStudents(e.target.value)}
                    >
                      {clas.map((clas, key) => {
                        return (
                          <IonSelectOption key={key} value={clas.id_class_diagram}>
                            {clas.name}
                          </IonSelectOption>
                        );
                      })}
                    </IonSelect>
                  </div>
                </IonCol>
              </IonRow>
            </IonGrid>
          </IonCardContent>
        </IonCard>
        {/* <IonGrid className="py-0 mt-3">
          <IonRow className="me-2 d-flex align-items-center ms-2">
            <IonSearchbar
              style={{ textAlign: "start", padding: "0" }}
              className="searchbar "
              color="light"
              debounce={1000}
              placeholder="Tìm tên học sinh"
            ></IonSearchbar>
          </IonRow>
        </IonGrid> */}
        <IonAccordionGroup className="mt-2 p-2">
          {listStudent.map((listStudent, key) => {
            return (
              <IonAccordion value={`${key}`} className="p-1 bg-color  mb-2">
                <IonItem slot="header" color="red" className="item-scores">
                  <IonCol size="2" className="p-3 fw-bold">
                    {key + 1}
                  </IonCol>
                  <IonLabel className="name">
                    {listStudent.firstname} {listStudent.lastname}
                    <p className="mt-2 text-secondary fw-medium">
                      Mã học sinh: {listStudent.id_student}
                    </p>
                  </IonLabel>
                </IonItem>
                <div className="p-1" slot="content">
                  <IonCard className="bg-card">
                    <IonCardContent className="card-content-grid-list">
                      <p className="link text-center mt-2">
                        <img
                          className="img-teacher w-50  rounded-circle"
                          alt="Avatar học sinh"
                          src={`${listStudent.avatar}`}
                        />
                      </p>
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Họ và tên:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          {listStudent.firstname} {listStudent.lastname}
                        </IonCol>
                      </IonRow>
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">
                            Mã học sinh:
                          </IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          {listStudent.id_student}
                        </IonCol>
                      </IonRow>
                      {/* <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Lớp:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          3A
                        </IonCol>
                      </IonRow> */}
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Ngày sinh:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          {moment(listStudent.birthday).format("DD-MM-YYYY")}
                        </IonCol>
                      </IonRow>
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Giới tính:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          {listStudent.gender}
                        </IonCol>
                      </IonRow>
                      {/* <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Địa chỉ:</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          54 Bàu Cát 6, phường 14, Tân Bình, HCM
                        </IonCol>
                      </IonRow> */}
                      <IonRow className="justify-content-end mt-1">
                        <Link to="/Profile">
                          <IonButton
                            size="small"
                            color={"warning"}
                            className="fw-bold"
                            onClick={handleItemClick}
                            key={listStudent.id}
                            id={listStudent.id}
                          >
                            Xem chi tiết
                          </IonButton>
                        </Link>
                      </IonRow>
                    </IonCardContent>
                  </IonCard>
                </div>
              </IonAccordion>
            );
          })}
        </IonAccordionGroup>
        {/* </IonGrid> */}
      </IonContent>
    </IonPage>
  );
};

export default OpinionDetail;
