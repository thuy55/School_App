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
  IonAvatar,
  IonSelect,
  IonSelectOption,
  IonGrid,
  IonImg,
  IonToast,
  IonBackButton,
} from "@ionic/react";

import "./teacher.css";
import { useEffect, useState } from "react";
import axios from "axios";
import moment from "moment";

const Page: React.FC = () => {
  const [subjects, setSubjects] = useState([] as any[]);

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
      .post(`/subject/` + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setSubjects(res.data.subject);
        }
      })
      .catch((error) => {});
  }, []);


  const [showToast, setShowToast] = useState(false);
  const [listTeacher, setListTeacher] = useState([] as any[]);
  function getListTeacher(e: any) {
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
      .post(`/subject_teacher/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.subject == null) {
            setShowToast(true);
            setListTeacher([]);
          } else {
          localStorage.setItem("id_subject", e);
          setListTeacher(res.data.subject);
          }
        }
      })
      .catch((error) => {});
  }
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Danh sách giáo viên</IonTitle>
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
              text: 'Đóng',
              role: 'cancel',
              handler: () => {
                setShowToast(false);
              }
            }
          ]}
        />
        <IonGrid className="py-0">
          <IonRow className="me-2 d-flex align-items-center ms-2 mt-2">
            <IonCol>
              <IonLabel className="lable-name">Môn học:</IonLabel>
            </IonCol>
            <IonCol size="9">
              <div style={{ width: "100%" }}>
                <IonSelect
                  className="select-name"
                  color="primary"
                  slot="start"
                  interface="popover"
                  placeholder="Chọn môn"
                  onIonChange={(e: any) => getListTeacher(e.target.value)}
                >
                  {subjects.map((subjects, key) => {
                    return <IonSelectOption key={key} value={subjects.id}>{subjects.name}</IonSelectOption>;
                  })}
                </IonSelect>
              </div>
            </IonCol>
          </IonRow>
        </IonGrid>
        <IonAccordionGroup className="mt-4 mx-2">
          <IonLabel className="p-3 mb-2 fw-bold">GIÁO VIÊN BỘ MÔN :</IonLabel>
          {listTeacher.map((listTeacher,key) =>{
            return(
          <IonAccordion value={`${listTeacher.teacher.id}`} className="mt-3 acc">
            <IonItem slot="header" color="red" className="item-teacher-1">
              <IonAvatar slot="start">
              <img alt="Avatar" src={`${listTeacher.teacher.avatar}`} />
                    <IonImg>{listTeacher.teacher.avatar}</IonImg>
              </IonAvatar>
              <IonLabel className="fw-bold">
               {listTeacher.teacher.firstname}  {listTeacher.teacher.lastname}
                <p className="mt-2 text-secondary">Môn dạy : {listTeacher.specialized.name}</p>
              </IonLabel>
            </IonItem>
            <div className="ion-padding p-0 pe-2" slot="content">
              <p
                className="link text-center mt-2"
                style={{ background: "#e3edf5" }}
              >
                <img
                 style={{ height: "180px" }}
                  className="img-teacher w-50  rounded-circle"
                  alt="Silhouette of mountains"
                  src={`${listTeacher.teacher.avatar}`}
                />
              </p>
              <ol id="accordion" className="rounded-list accordion">
                <li>
                  <ol>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Họ và tên :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                          {listTeacher.teacher.firstname}  {listTeacher.teacher.lastname}

                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Môn dạy :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                          {listTeacher.specialized.name}
                          </IonCol>
                        </IonRow>{" "}
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Học hàm :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            {listTeacher.teacher.academic_function}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Điện thoại :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                           {listTeacher.teacher.phone_number}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Giới tính :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            {listTeacher.teacher.gender}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Ngày sinh :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                          {moment(listTeacher.birthday).format("DD-MM-YYYY")}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">Email :</IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                           {listTeacher.teacher.email}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Địa chỉ :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                           {listTeacher.teacher.address}
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                  </ol>
                </li>
              </ol>
            </div>
          </IonAccordion>
            )
          })}
          {/* <IonAccordion value="first" className="mt-3 acc">
            <IonItem slot="header" color="red" className="item-teacher-1">
              <IonAvatar slot="start">
                <img
                  alt="Silhouette of a person's head"
                  src="https://ionicframework.com/docs/img/demos/avatar.svg"
                />
              </IonAvatar>
              <IonLabel className="fw-bold">
                Nguyễn Thị Thắm
                <p className="mt-2 text-secondary">Môn dạy : Tiếng Việt</p>
              </IonLabel>
            </IonItem>
            <div className="ion-padding p-0 pe-2" slot="content">
              <p
                className="link text-center mt-2"
                style={{ background: "#e3edf5" }}
              >
                <img
                  className="img-teacher w-50  rounded-circle"
                  alt="Silhouette of mountains"
                  src="https://ionicframework.com/docs/img/demos/thumbnail.svg"
                />
              </p>
              <ol id="accordion" className="rounded-list accordion">
                <li>
                  <ol>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Họ và tên :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Nguyễn Thị Thắm
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Môn dạy :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Tiếng Việt
                          </IonCol>
                        </IonRow>{" "}
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Học hàm :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Thạc sĩ
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Điện thoại :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            0123456789
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Giới tính :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Nữ
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Ngày sinh :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            02/04/1989
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">Email :</IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            info@eclo.vn
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Địa chỉ :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            54 Bàu Cát 6, P14, Tân Bình, tpHCM
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                  </ol>
                </li>
              </ol>
            </div>
          </IonAccordion>
          <IonAccordion value="3" className="mt-3 acc">
            <IonItem slot="header" color="red" className="item-teacher-1">
              <IonAvatar slot="start">
                <img
                  alt="Silhouette of a person's head"
                  src="https://ionicframework.com/docs/img/demos/avatar.svg"
                />
              </IonAvatar>
              <IonLabel className="fw-bold">
                Nguyễn Thị Thắm
                <p className="mt-2 text-secondary">Môn dạy : Tiếng Việt</p>
              </IonLabel>
            </IonItem>
            <div className="ion-padding p-0 pe-2" slot="content">
              <p
                className="link text-center mt-2"
                style={{ background: "#e3edf5" }}
              >
                <img
                  className="img-teacher w-50  rounded-circle"
                  alt="Silhouette of mountains"
                  src="https://ionicframework.com/docs/img/demos/thumbnail.svg"
                />
              </p>
              <ol id="accordion" className="rounded-list accordion">
                <li>
                  <ol>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Họ và tên :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Nguyễn Thị Thắm
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Môn dạy :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Tiếng Việt
                          </IonCol>
                        </IonRow>{" "}
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Học hàm :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Thạc sĩ
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Điện thoại :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            0123456789
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Giới tính :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            Nữ
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Ngày sinh :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            02/04/1989
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">Email :</IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            info@eclo.vn
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                    <li>
                      <p className="link">
                        <IonRow className="row text-align-center">
                          <IonCol>
                            <IonLabel className="lable-name">
                              Địa chỉ :
                            </IonLabel>
                          </IonCol>
                          <IonCol size="8" className="nd">
                            54 Bàu Cát 6, P14, Tân Bình, tpHCM
                          </IonCol>
                        </IonRow>
                      </p>
                    </li>
                  </ol>
                </li>
              </ol>
            </div>
          </IonAccordion> */}
        </IonAccordionGroup>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default Page;
