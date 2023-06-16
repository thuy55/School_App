import { useParams } from "react-router";
import {
  IonCol,
  IonAvatar,
  IonItem,
  IonLabel,
  IonThumbnail,
  IonButton,
  IonGrid,
  IonRow,
  IonIcon,
  IonCard,
  IonPage,
  IonHeader,
  IonToolbar,
  IonButtons,
  IonMenuButton,
  IonTitle,
  IonContent,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonBackButton,
} from "@ionic/react";
import { timer, home } from "ionicons/icons";
import { Link } from "react-router-dom";
import "./Profile.css";
import { useEffect, useState } from "react";
import axios from "axios";
import moment from "moment";
const Page: React.FC = () => {
  const [student, setStudent] = useState([] as any[]);
  const [ward, setWard] = useState([] as any[]);
  const [province, setProvince] = useState([] as any[]);
  const [district, setDistrict] = useState([] as any[]);
  const [ethnic, setethnic] = useState([] as any[]);
  const [religion, setreligion] = useState([] as any[]);
  const [nationality, setnationality] = useState([] as any[]);
  const [priority_object, setpriority_object] = useState([] as any[]);
  const [allergy, setallergy] = useState([] as any[]);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id = localStorage.getItem("id_student");
    const loginData = {
      token: x,
      id_student: id,
    };
    api
      .post("/profile_student/" + id, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setStudent(res.data.students);
          setWard(res.data.ward);
          setProvince(res.data.province);
          setDistrict(res.data.district);
          setethnic(res.data.ethnic);
          setreligion(res.data.religion);
          setnationality(res.data.nationality);
          setpriority_object(res.data.priority_object);
          setallergy(res.data.allergy);
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
          <IonTitle>Thông tin học sinh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
        <article className="bg-xl pb-1">
          <div className=" before-bg-style">
            <div className="profile">
              {student.map((student, key) => {
                return (
                  <div className="avatar">
                    <img
                      className="avatar-img"
                      src={`${student.avatar}`}
                      alt=""
                    />
                  </div>
                );
              })}
              <IonCardContent className="bg-3 ms-0 me-0 profile ps-2">
                <IonGrid className="pv">
                  {student.map((student, key) => {
                    return (
                      <>
                        <IonRow className="pt-4">
                          <IonCol className="text-2">Mã học sinh:</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.id_student}
                          </IonCol>
                        </IonRow>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">Họ và tên:</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.firstname} {student.lastname}
                          </IonCol>
                        </IonRow>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">Ngày sinh:</IonCol>
                          <IonCol className="text-1" size="7">
                            {moment(student.birthday).format("DD-MM-YYYY")}
                          </IonCol>
                        </IonRow>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">Giới tính :</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.gender}
                          </IonCol>
                        </IonRow>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">Sở thích :</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.hobby}
                          </IonCol>
                        </IonRow>
                      </>
                    );
                  })}
                  <IonRow className="pt-3">
                    <IonCol className="text-2">Dị ứng:</IonCol>
                    <IonCol className="text-1" size="7">
                      {allergy}
                    </IonCol>
                  </IonRow>
                  <IonRow className="pt-3">
                    <IonCol className="text-2">Đối tượng:</IonCol>
                    <IonCol className="text-1" size="7">
                      {priority_object}
                    </IonCol>
                  </IonRow>
                  {student.map((student, key) => {
                    return (
                      <>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">BH y tế:</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.health_insurance_id}
                          </IonCol>
                        </IonRow>
                        <IonRow className="pt-3">
                          <IonCol className="text-2">BH thân thể:</IonCol>
                          <IonCol className="text-1" size="7">
                            {student.body_insurance_id}
                          </IonCol>
                        </IonRow>
                      </>
                    );
                  })}
                  <IonRow className="pt-3">
                    <IonCol className="text-2">Dân tộc:</IonCol>
                    <IonCol className="text-1" size="7">
                      {ethnic}
                    </IonCol>
                  </IonRow>

                  <IonRow className="pt-3">
                    <IonCol className="text-2">Tôn giáo:</IonCol>
                    <IonCol className="text-1" size="7">
                      {religion}
                    </IonCol>
                  </IonRow>
                  {student.map((student, key) => {
                    return (
                      <IonRow className="pt-3">
                        <IonCol className="text-2">Nơi sinh:</IonCol>
                        <IonCol className="text-1" size="7">
                          {student.address} {ward} {district} {province}
                        </IonCol>
                      </IonRow>
                    );
                  })}

                  <IonRow className="pt-3">
                    <IonCol className="text-2">Quốc tịch:</IonCol>
                    <IonCol className="text-1" size="7">
                      {nationality}
                    </IonCol>
                  </IonRow>
                </IonGrid>
                <IonCardTitle className="fw-1 p-2"></IonCardTitle>
              </IonCardContent>
            </div>
          </div>
          {/* <IonCard>
            <img
              alt="Silhouette of mountains"
              src="https://vnn-imgs-a1.vgcloud.vn/znews-photo.zadn.vn/w1024/Uploaded/lce_cjvcc/2019_08_07/Blue_Bird_Vision_Montevideo_54.jpg"
            />
            <IonCardHeader className="p-2 ps-4">
              <IonCardTitle className="car-name text-wrap fs-4">
                <IonItem href="#">
                  <IonAvatar slot="start">
                    <img
                      alt="Silhouette of a person's head"
                      src="https://ionicframework.com/docs/img/demos/avatar.svg"
                    />
                  </IonAvatar>
                  <IonLabel className="text-center">
                    Tài xế: Chu chỉ nhược
                  </IonLabel>
                </IonItem>
              </IonCardTitle>
            </IonCardHeader>

            <IonCardContent>
              <IonGrid className="">
                <IonRow className="pt-1">
                  <IonCol className="text-2">Loại xe</IonCol>
                  <IonCol className="text-1" size="7">
                    14 chỗ
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Biển số xe:</IonCol>
                  <IonCol className="text-1" size="7">
                    552277-NB
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Số học sinh:</IonCol>
                  <IonCol className="text-1" size="7">
                    14
                  </IonCol>
                </IonRow>
              </IonGrid>
            </IonCardContent>
          </IonCard> */}
          {/* <IonCard className="card-profile">
            <IonCardHeader>
              <IonCardTitle className="fw-1">
                THÔNG TIN HỒ SƠ HỌC SINH
              </IonCardTitle>
            </IonCardHeader>
            <IonCardContent className="bg-2 ps-2">
              <IonGrid className="pv">
                <IonRow className="pt-3">
                  <IonCol className="text-2">Mẫ hồ sơ:</IonCol>
                  <IonCol className="text-1" size="7">
                    22077551
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Ngày nhập học:</IonCol>
                  <IonCol className="text-1" size="7">
                    17/20/2222
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Bật đào tạo:</IonCol>
                  <IonCol className="text-1" size="7">
                    Tiểu học
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Năm học:</IonCol>
                  <IonCol className="text-1" size="7">
                    2022-2023
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Khóa học:</IonCol>
                  <IonCol className="text-1" size="7">
                    2020-2024
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Loại đào tạo:</IonCol>
                  <IonCol className="text-1" size="7">
                    Chính quy
                  </IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Đơn vị đào tạo:</IonCol>
                  <IonCol className="text-1" size="7">
                    Trường tiểu học lương văn an
                  </IonCol>
                </IonRow>
              </IonGrid>
              <IonCardTitle className="fw-1 p-2"></IonCardTitle>
            </IonCardContent>
          </IonCard> */}
          {/* <IonCard className="card-profile">
            <IonCardHeader>
              <IonCardTitle className="fw-1">QUAN HỆ GIA ĐÌNH</IonCardTitle>
            </IonCardHeader>
            <IonCardHeader className="bg-2  p-1 ps-0 pt-3">
              <section className="page-section p-4 pt-0">
                <ul className="linetime">
                  <li>
                    <div className="linetime-img rounded-circle">
                      <img
                        src="https://anhnendep.net/wp-content/uploads/2016/04/hinh-avata-chibi-de-thuong-cute-10.jpg"
                        alt=""
                        className="img-fluid"
                      />
                    </div>
                    <div className="linetime-panel">
                      <div className="linetime-panel-heading">
                        <h4 className="size-18">Thông tin mẹ</h4>
                      </div>
                      <div className="linetime-panel-subheading">
                        <h3 className="size-18 text-primary fw-bold">
                          Nguyễn văn bé
                        </h3>
                      </div>
                      <div className="linetime-panel-content">
                        <Link
                          to="/ProfileMom"
                          className="list-group-item  p-0 list-group-item-action"
                        >
                          <IonButton
                            className="w-bt"
                            color="tertiary"
                            expand="block"
                          >
                            Xem thêm...
                          </IonButton>
                        </Link>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div className="linetime-img rounded-circle">
                      <img
                        src="https://anhnendep.net/wp-content/uploads/2016/04/hinh-avata-chibi-de-thuong-cute-10.jpg"
                        alt=""
                        className="img-fluid"
                      />
                    </div>
                    <div className="linetime-panel inverted">
                      <div className="linetime-panel-heading">
                        <h4 className="size-18">Thông tin cha</h4>
                      </div>
                      <div className="linetime-panel-subheading">
                        <h3 className="size-18 text-primary fw-bold">
                          Nguyễn Văn Anh
                        </h3>
                      </div>
                      <div className="linetime-panel-content">
                        <Link
                          to="/ProfileDad"
                          className="list-group-item  p-0 list-group-item-action"
                        >
                          <IonButton
                            className="w-bt bg-bt"
                            color="warning"
                            expand="block"
                          >
                            Xem thêm...
                          </IonButton>
                        </Link>
                      </div>
                    </div>
                  </li>
                </ul>
              </section>
            </IonCardHeader>
          </IonCard> */}
        </article>
      </IonContent>
    </IonPage>
  );
};

export default Page;
