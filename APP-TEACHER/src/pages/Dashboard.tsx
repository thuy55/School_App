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
  IonCardTitle,
  IonItem,
  IonCardSubtitle,
  IonList,
  IonThumbnail,
  useIonAlert,
  useIonLoading,
  IonBadge,
  IonImg,
} from "@ionic/react";
import React from "react";
import axios from "axios";
// import { useParams } from 'react-router';
// import ExploreContainer from '../components/ExploreContainer';
import "./Dashboard.css";
import { IonLabel, IonCol, IonGrid, IonRow } from "@ionic/react";
import { IonSelect, IonSelectOption, IonIcon } from "@ionic/react";
// import { IonReactRouter } from '@ionic/react-router';
// import { Redirect, Route } from 'react-router-dom';
// import Menu from '../components/Menu';
import {
  calendarOutline,
  schoolOutline,
  alarmOutline,
  fitnessOutline,
  notifications,
  notificationsCircleOutline,
  brush,
  layersOutline,
  backspaceOutline,
  peopleOutline,
  personCircleOutline,
  person,
  printOutline,
  createOutline,
  calculatorOutline,
  playCircle,
  radio,
  library,
  search,
  earth,
  call,
  locationOutline,
  libraryOutline,
  golfOutline,
  receiptOutline,
  busOutline,
  notificationsOutline,
  bulbSharp,
  boatOutline,
} from "ionicons/icons";
import { Link } from "react-router-dom";
// import { setUserSession } from "./Common";
import { useState, useEffect } from "react";

interface ContainerProps {}

const Home: React.FC = () => {
  const current = new Date();
  const date = `${current.getDate()}/${
    current.getMonth() + 1
  }/${current.getFullYear()}`;

  const [presentAlert] = useIonAlert();
  const [present, dismiss] = useIonLoading();
  const [school_teacher, setSchool_teacher] = useState([] as any[]);
  const [teacher, setTeacher] = useState([] as any[]);
  const [infoSchool, setInfoSchool] = useState([] as any[]);
  const [idSchool, setidSchool] = useState("");

  const [selectedOption, setSelectedOption] = useState<any>(null);
  const [selectedOptioncourse, setSelectedOptioncourse] = useState<any>(null);
  useEffect(() => {
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_school_teacher = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
    };
    api
      .post("/school-teacher", loginData)
      .then((res) => {
        if (res.data.status == "success") {
          if (res.data.content.length == 1) {
            const ids = res.data.content;
            const id = ids[0].id;
            setSchool_teacher(res.data.content);
            localStorage.setItem("id_school_teacher", id);
            getCourse(id);
          } else {
            if (id_school_teacher == null) {
              presentAlert({
                header: "Vui lòng chọn trường",
                // message: res.data.content,
                buttons: ["OK"],
              });

              setSchool_teacher(res.data.content);
            }            
            else {
              setSelectedOption(id_school_teacher);
              getCourse(id_school_teacher);
              setSchool_teacher(res.data.content);
            
            }
          }
        }
      })
      .catch((error) => {});
  }, []);
  const [course, setScourse] = useState([] as any[]);
  function getCourse(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_course = localStorage.getItem("id_course");
    const loginData = {
      token: x,
    };
    api
      .post(`/course-school-teacher/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          // localStorage.removeItem("id_school_teacher");
          localStorage.setItem("id_school_teacher", e);
          setSelectedOption(value);
          if (res.data.content.length == 1) {
            const ids = res.data.content;
            const id = ids[0].id;
            setSelectedOptioncourse(id_course);
            setScourse(res.data.content);
            setInfoSchool(res.data.school);
            localStorage.setItem("id_course", id);
            getTeacher(id);
          } else {
            console.log("ssssssssssss", e);
            if (id_course == null) {
              presentAlert({
                header: "Vui lòng chọn khóa học",
                buttons: ["OK"],
              });
              setSelectedOption(value); // Cập nhật giá trị selectedOption
              setScourse(res.data.content);
              setInfoSchool(res.data.school);
            }else{
            setSelectedOptioncourse(id_course);
            getTeacher(id_course);
            setScourse(res.data.content);
            setInfoSchool(res.data.school);
            
            }
          }
        }
      })
      .catch((error) => {});
  }
  const [count_school, setcount_school] = useState<number>(0);
  const [count_parent, setcount_parent] = useState<number>(0);
  const [count_furlough, setcount_furlough] = useState<number>(0);
  const [count_student_register_car, setcount_student_register_car] =
    useState<number>(0);

  const [regent, setRegent] = useState([] as any[]);
  const [clas, setClas] = useState([] as any[]);
  const [classroom, setClassroom] = useState([] as any[]);
  const [ma, setMa] = useState([] as any[]);

  const [checkin, setCheckin] = useState([] as any[]);
  const [chechout, setcheckout] = useState([] as any[]);
  function getTeacher(e: any) {
    if (e && e.target && e.target.value) {
      var value = e.target.value;
      // Tiếp tục xử lý dữ liệu...
    }
    const api = axios.create({
      baseURL: "https://school.hewo.vn/api",
    });
    var x = localStorage.getItem("token");
    var id_school_teacher = localStorage.getItem("id_school_teacher");
    const loginData = {
      token: x,
      id_school_teacher: id_school_teacher,
    };
    api
      .post(`/teachers/` + e, loginData)
      .then((res) => {
        if (res.data.status == "success") {
          setSelectedOptioncourse(value); // Cập nhật giá trị selectedOption
          localStorage.setItem("id_course", e);
          setTeacher(res.data.teacher);
          setRegent(res.data.regent);
          setClas(res.data.class);
          setClassroom(res.data.classroom);
          setMa(res.data.id_teacher);
          setcount_school(res.data.count_school);
          setcount_parent(res.data.count_parent);
          setcount_furlough(res.data.count_furlough);
          setcount_student_register_car(res.data.count_student_register_car);
          setCheckin(res.data.timekeeping.checkin);
          setcheckout(res.data.timekeeping.checkout);
        }
      })
      .catch((error) => {});
  }
  function handleGoBack(event: any) {
    // const itemId = event.target.id;
    localStorage.removeItem("type_Go_Back");
    localStorage.setItem("type_Go_Back", "1");
    // console.log(itemId);
  }
  function handleToken(name: any) {
    localStorage.removeItem("school_name");
    localStorage.setItem("school_name", name);
    // console.log(project_token);
  }

  const [scrollPosition, setScrollPosition] = useState(0);
  const [isSwipingDown, setIsSwipingDown] = useState(false);

  const handleTouchStart = (e: any) => {
    setScrollPosition(e.touches[0].clientY);
  };

  const handleTouchMove = (e: any) => {
    const currentPosition = e.touches[0].clientY;
    setIsSwipingDown(currentPosition > scrollPosition);
  };

  const handleTouchEnd = () => {
    if (isSwipingDown) {
      window.location.reload(); // Reload trang
    }
    setIsSwipingDown(false);
  };

  return (
    <div
      onTouchStart={handleTouchStart}
      onTouchMove={handleTouchMove}
      onTouchEnd={handleTouchEnd}
    >
      <IonPage>
        <IonHeader>
          <IonToolbar>
            <IonButtons slot="start">
              <IonMenuButton />
            </IonButtons>
            <IonTitle>Trang chủ</IonTitle>
            {/* <div
              slot="end"
              className="w-25 d-flex justify-content-end me-3 rounded-circle"
            >
              <img
                src="https://gray-wkyt-prod.cdn.arcpublishing.com/resizer/TE7IhQt_Q825GVgDDtkXGb75mkw=/1200x675/smart/filters:quality(85)/cloudfront-us-east-1.images.arcpublishing.com/gray/W5DRRSQN4RETPH7TKOZRHBHCRA.jpg"
                className=" rounded-circle"
                style={{width:"45px", height:"45px"}}
              ></img>
            </div> */}
          </IonToolbar>
        </IonHeader>

        <IonContent className="container">
          <IonCard className="card-home-dashboard mx-1">
            <IonCardContent className="card-content-dashboard">
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Tên trường :</IonLabel>
                  </IonCol>
                  <IonCol size="7">
                    <div style={{ width: "100%" }}>
                      <select
                        className="select-name border border-1 w-100"
                        slot="start"
                        data-toggle="popover"
                        value={selectedOption}
                        placeholder="Chọn trường"
                        style={{ backgroundColor: "rgb(231, 220, 220)" }}
                        onChange={(e: any) => getCourse(e.target.value)}
                      >
                        {school_teacher.length > 1 ? (
                          <option value={""}>Chọn trường</option>
                        ) : null}
                        {school_teacher.map((school_teacher, key) => {
                          return (
                            <option key={key} value={school_teacher.id}>
                              {school_teacher.name}
                            </option>
                          );
                        })}
                      </select>
                    </div>
                  </IonCol>
                </IonRow>
              </IonGrid>
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Khóa học :</IonLabel>
                  </IonCol>
                  <IonCol size="7">
                    <div style={{ width: "100%" }}>
                      <select
                        className="select-name border border-1 w-100"
                        slot="start"
                        // interface="popover"
                        data-toggle="popover"
                        value={selectedOptioncourse}
                        placeholder="Chọn khóa học"
                        style={{ backgroundColor: "rgb(231, 220, 220)" }}
                        onChange={(e: any) => getTeacher(e.target.value)}
                      >
                        {course.length > 1 ? (
                          <option value={""}>Chọn khóa học</option>
                        ) : null}
                        {course.map((course, key) => {
                          return (
                            <option key={key} value={course.id}>
                              {course.name}
                            </option>
                          );
                        })}
                      </select>
                    </div>
                  </IonCol>
                </IonRow>
              </IonGrid>
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Họ và tên :</IonLabel>
                  </IonCol>
                  {teacher.map((teacher, key) => {
                    return (
                      <IonCol size="7">
                        {teacher.firstname} {teacher.lastname}
                      </IonCol>
                    );
                  })}
                </IonRow>
              </IonGrid>
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Mã giáo viên :</IonLabel>
                  </IonCol>
                  <IonCol className="tt" size="7">
                    {ma}
                  </IonCol>
                </IonRow>
              </IonGrid>
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Chức vụ :</IonLabel>
                  </IonCol>
                  {regent.map((regent, key) => {
                    return (
                      <IonCol className="tt" size="7">
                        {regent.name}
                      </IonCol>
                    );
                  })}
                </IonRow>
              </IonGrid>

              {clas.map((clas, key) => {
                if (clas != null) {
                  return (
                    <IonGrid className="grid">
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">
                            Lớp chủ nhiệm :
                          </IonLabel>
                        </IonCol>

                        <IonCol className="tt" size="7">
                          {clas.name}
                        </IonCol>
                      </IonRow>
                    </IonGrid>
                  );
                }
              })}
              {classroom.map((classroom, key) => {
                if (classroom != null) {
                  return (
                    <IonGrid className="grid">
                      <IonRow className="row">
                        <IonCol>
                          <IonLabel className="lable-name">Phòng :</IonLabel>
                        </IonCol>
                        <IonCol className="tt" size="7">
                          {classroom.name}
                        </IonCol>
                      </IonRow>
                    </IonGrid>
                  );
                }
              })}
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name">Ngày hiện tại :</IonLabel>
                  </IonCol>
                  <IonCol className="tt" size="7">
                    <h5>{date}</h5>
                  </IonCol>
                </IonRow>
              </IonGrid>
              <IonGrid className="grid">
                <IonRow className="row">
                  <IonCol>
                    <IonLabel className="lable-name fw-bold text-danger">
                      Giờ vào : {checkin}
                    </IonLabel>
                  </IonCol>
                  <IonCol className="tt fw-bold text-danger" size="7">
                    Giờ ra : {chechout}
                  </IonCol>
                </IonRow>
              </IonGrid>
            </IonCardContent>
          </IonCard>
          <IonGrid>
            <IonRow>
              <IonCol>
                <Link to="/attendance">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={alarmOutline}
                        size="large"
                        color="warning"
                        style={{ marginBottom: 1, color: "#FF1493" }}
                      ></IonIcon>
                      <h6>Điểm danh HS</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/Scores">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={brush}
                        size="large"
                        style={{ marginBottom: 1, color: "#CD853F" }}
                      ></IonIcon>
                      <h6>Điểm</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/Schedule">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={calendarOutline}
                        size="large"
                        color="tertiary"
                        style={{ marginBottom: 1 }}
                      ></IonIcon>
                      <h6>Lịch dạy</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol>
                <Link to="/AttendanceTeacher">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={golfOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#CD853F" }}
                      ></IonIcon>
                      <h6>Nhận diện</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/lessionPlan">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={libraryOutline}
                        size="large"
                        color="warning"
                        style={{ marginBottom: 1, color: "#FF1493" }}
                      ></IonIcon>
                      <h6>Giáo án</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>

              <IonCol>
                <Link to="/noteBook">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={receiptOutline}
                        size="large"
                        color="tertiary"
                        style={{ marginBottom: 1 }}
                      ></IonIcon>
                      <h6>Sổ đầu bài</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol>
                <Link to="/note">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={calculatorOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#808000" }}
                      ></IonIcon>
                      <h6>Ghi chú</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/Debt">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={printOutline}
                        size="large"
                        color="danger"
                        style={{ marginBottom: 1 }}
                      ></IonIcon>
                      <h6>Công nợ</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/listStudent">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={personCircleOutline}
                        size="large"
                        color="tertiary"
                        style={{ marginBottom: 1 }}
                      ></IonIcon>
                      <h6>Học sinh</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol>
                <Link to="/meals">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={layersOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#000080" }}
                      ></IonIcon>
                      <h6>Thực đơn</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>

              <IonCol>
                <Link to="/Move">
                  <IonCard
                    onClick={handleGoBack}
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent
                      className="card-content-grid"
                      onClick={handleGoBack}
                    >
                      <IonIcon
                        icon={busOutline}
                        size="large"
                        color="danger"
                        style={{ marginBottom: 1 }}
                        onClick={handleGoBack}
                      ></IonIcon>
                      <h6>Đưa đón</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/HealthRecord">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={fitnessOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#800080" }}
                      ></IonIcon>
                      <h6>Sức khỏe</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol>
                <Link to="/news">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={schoolOutline}
                        size="large"
                        color="primary"
                        style={{ marginBottom: "1" }}
                      ></IonIcon>
                      <h6>Hoạt động</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/notifications">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <div className="notification-icon-container">
                        {count_school === 0 ? (
                          <IonIcon
                            icon={notifications}
                            size="large"
                            color="success"
                            style={{ marginBottom: 1 }}
                          ></IonIcon>
                        ) : null}

                        {count_school > 0 ? (
                          <>
                            <IonIcon
                              icon={notifications}
                              size="large"
                              color="success"
                              style={{ marginBottom: 1 }}
                              className="faa-ring animated"
                            ></IonIcon>
                            <IonBadge
                              color="danger"
                              className="notification-badge"
                            >
                              {count_school}
                            </IonBadge>
                          </>
                        ) : null}
                        <h6>Thông báo</h6>
                      </div>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/notificationTeacher">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={notificationsCircleOutline}
                        size="large"
                        color="medium"
                        style={{ marginBottom: 1 }}
                      ></IonIcon>
                      <h6>Thông báo GV</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol>
                <Link to="/Teacher">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={peopleOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#FF00FF" }}
                      ></IonIcon>
                      <h6>Giáo viên</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/Cash">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={calculatorOutline}
                        size="large"
                        style={{ marginBottom: 1, color: "#808000" }}
                      ></IonIcon>
                      <h6>Sổ thu chi</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol>
                <Link to="/Account">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      <IonIcon
                        icon={person}
                        size="large"
                        style={{ marginBottom: 1, color: "#006400" }}
                      ></IonIcon>
                      <h6>Tài khoản</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
            <IonRow>
              <IonCol className="col-33">
                <Link to="/notificationParent">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      {count_parent === 0 ? (
                        <IonIcon
                          icon={notificationsOutline}
                          size="large"
                          color="dark"
                          style={{ marginBottom: 1 }}
                        ></IonIcon>
                      ) : null}

                      {count_parent > 0 ? (
                        <>
                          <IonIcon
                            icon={notificationsOutline}
                            size="large"
                            color="dark"
                            style={{ marginBottom: 1 }}
                            className="faa-ring animated"
                          ></IonIcon>
                          <IonBadge
                            color="danger"
                            className="notification-badge"
                          >
                            {count_parent}
                          </IonBadge>
                        </>
                      ) : null}
                      <h6>Thông báo PH</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol className="col-33">
                <Link to="/registerBus">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      {count_student_register_car === 0 ? (
                        <IonIcon
                          icon={bulbSharp}
                          size="large"
                          color="warning"
                          style={{ marginBottom: 1 }}
                        ></IonIcon>
                      ) : null}

                      {count_student_register_car > 0 ? (
                        <>
                          <IonIcon
                            icon={bulbSharp}
                            size="large"
                            color="warning"
                            style={{ marginBottom: 1 }}
                            className="faa-ring animated"
                          ></IonIcon>

                          <IonBadge
                            color="danger"
                            className="notification-badge"
                          >
                            {count_student_register_car}
                          </IonBadge>
                        </>
                      ) : null}
                      <h6>Đăng kí xe</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
              <IonCol className="col-33">
                <Link to="/leave">
                  <IonCard
                    className="card-grid-dashboard item-list-dashboard"
                    button
                  >
                    <IonCardContent className="card-content-grid">
                      {count_furlough === 0 ? (
                        <IonIcon
                          icon={boatOutline}
                          size="large"
                          color="danger"
                          style={{ marginBottom: 1 }}
                        ></IonIcon>
                      ) : null}

                      {count_furlough > 0 ? (
                        <>
                          <IonIcon
                            icon={boatOutline}
                            size="large"
                            color="danger"
                            style={{ marginBottom: 1 }}
                            className="faa-ring animated"
                          ></IonIcon>
                          <IonBadge
                            color="danger"
                            className="notification-badge"
                          >
                            {count_furlough}
                          </IonBadge>
                        </>
                      ) : null}
                      <h6>Xin nghi phép</h6>
                    </IonCardContent>
                  </IonCard>
                </Link>
              </IonCol>
            </IonRow>
          </IonGrid>

          {infoSchool.map((infoSchool, key) => {
            return (
              <>
                <IonLabel>
                  <h1 className="text-dark fs-6 mt-2 mb-2 p-2">Giới thiệu:</h1>
                </IonLabel>

                <IonCard
                  className="card-news m-0 mx-2"
                  style={{ backgroundColor: "#e7eaf1" }}
                >
                  <img
                    alt="Silhouette of mountains"
                    src="https://bcp.cdnchinhphu.vn/Uploaded/phungthithuhuyen/2020_06_16/Resize%20of%20truonghoc.png"
                  />
                  <IonCardHeader className="pd">
                    <IonCardTitle className="font font2">
                      {infoSchool.name}
                    </IonCardTitle>
                  </IonCardHeader>
                  <IonCardContent className="news">
                    Thông tin sở giáo dục và đào tạo hoạt động trường dựa trên,
                    tin sở giáo dục và đào tạo hoạt động trường dựa trên ...
                    <IonCardSubtitle className="">
                      <IonCardContent className="p-0 ">
                        <IonList className="pd0">
                          <IonList className="">
                            <IonItem className="h ">
                              <IonThumbnail
                                className="m-0   text-center"
                                slot="start"
                              >
                                <IonIcon
                                  className="iconic "
                                  icon={earth}
                                ></IonIcon>
                              </IonThumbnail>
                              <IonLabel className="m-0 p-0 ">
                                {infoSchool.website}
                              </IonLabel>
                            </IonItem>

                            <IonItem className="h">
                              <IonThumbnail
                                className="m-0 text-center"
                                slot="start"
                              >
                                <IonIcon
                                  className="iconic"
                                  icon={call}
                                ></IonIcon>
                              </IonThumbnail>
                              <IonLabel className="m-0">
                                {infoSchool.phone_number}
                              </IonLabel>
                            </IonItem>

                            <IonItem className="h">
                              <IonThumbnail
                                className="m-0 text-center"
                                slot="start"
                              >
                                <IonIcon
                                  className="iconic"
                                  icon={locationOutline}
                                ></IonIcon>
                              </IonThumbnail>
                              <IonLabel className="m-0">
                                {infoSchool.address}
                              </IonLabel>
                            </IonItem>

                            <IonItem className="h">
                              <IonThumbnail
                                className="m-0 text-center"
                                slot="start"
                              >
                                <IonIcon
                                  className="iconic"
                                  icon={earth}
                                ></IonIcon>
                              </IonThumbnail>
                              <IonLabel className="m-0">
                                {infoSchool.email}{" "}
                              </IonLabel>
                            </IonItem>
                          </IonList>
                        </IonList>
                        <IonCardHeader className="notifile2">
                          <IonCardSubtitle className="colordate">
                            <IonRow>
                              <IonCol className="text1" size="6">
                                January 20, 2015
                              </IonCol>
                            </IonRow>
                          </IonCardSubtitle>
                        </IonCardHeader>
                      </IonCardContent>
                    </IonCardSubtitle>
                  </IonCardContent>
                </IonCard>
              </>
            );
          })}
        </IonContent>
      </IonPage>
    </div>
  );
};

export default Home;
