import {
    IonButtons,
    IonContent,
    IonHeader,
    IonPage,
    IonTitle,
    IonToolbar,
    IonItem,
    IonIcon,
    IonCard,
    IonChip,
    IonCardContent,
    IonGrid,
    IonRow,
    IonCol,
    IonToast,
    IonBackButton,
  } from "@ionic/react";
  import "./AttendanceTeacher.css";
  import { cubeSharp } from "ionicons/icons";
  import React, { useEffect, useRef, useState } from "react";
  import axios from "axios";
  import moment from "moment";
  const AttendanceDiary: React.FC = () => {
    const [startDate, setStartDate] = useState([] as any[]);
    const [endDate, setEndDate] = useState([] as any[]);
  
    const [attendance, setAttendance] = useState([] as any[]);
    const [date, setDate] = useState([] as any[]);
    const [showToast, setShowToast] = useState(false);
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
        .post(`/attendance_of_teacher`, loginData)
        .then((res) => {
          const startDate = res.data.datestart;
          const endDate = res.data.dateend;
          setStartDate(startDate);
          setEndDate(endDate);
  
          if (res.data.status == "success") {
            if (res.data.content == null) {
              setShowToast(true);
            } else {
              setAttendance(res.data.content);
              // setDate(res.data.day_week2);
            }
          }
        })
        .catch((error) => {});
    }, []);
  
    const [dateSearch, setDateSearch] = useState([] as any[]);
    const [dateNow, setDateNow] = useState([] as any[]);
    function getSearch(e: any) {
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
        .post(`/attendance_search_of_teacher/` + e, loginData)
        .then((res) => {
          // setDateSearch(res.data.month_year);
          if (res.data.status == "success") {
            localStorage.removeItem("date_string");
            localStorage.setItem("date_string", e);
            
            setAttendance(res.data.content);
            // setDateNow(res.data.date_now);
          }
        })
        .catch((error) => {});
    }
    return (
      <IonPage>
        <IonHeader>
          <IonToolbar>
            <IonButtons slot="start">
              {/* <IonMenuButton></IonMenuButton> */}
              <IonBackButton></IonBackButton>
            </IonButtons>
            <IonTitle>Nhật ký điểm danh</IonTitle>
          </IonToolbar>
        </IonHeader>
        <IonContent fullscreen>
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
          <div className="row">
            <div className="col-lg-12">
              <div className="card">
                <div
                  className="card-body pt-0 pe-2 ps-2 "
                  style={{ backgroundColor: "#f6faff" }}
                >
                  <div className="card-title d-flex boder-bottom-0 mb-1 align-items-center justify-content-center">
                    <IonItem
                      className="boder-bottom-0"
                      style={{ marginTop: "10px" }}
                    >
                      <label>Ngày:</label>
                      <input
                        className="ms-1"
                        type="date"
                        // id="typeDate"
                        // name="typeDate"
                        onChange={(e: any) => getSearch(e.target.value)}
                        defaultValue={startDate}
                      ></input>
                    </IonItem>
                  </div>
                  <div className="hori-timeline" dir="ltr">
                    <ul className="list-inline events">
                      {attendance.map((attendance, key) => {
                        console.log(attendance.date)
                      
                        if (attendance.type == "1"  ) {
                          return (
                            <li
                              className="list-inline-item event-list w-100"
                              
                            >
                              <div className="event-date bg-soft-primary w-100 text-primary" >
                                {attendance.day_of_week} (
                                {moment(attendance.date).format("DD-MM-YYYY")})
                              </div>
                              <div className="d-flex">
                                <div
                                  className="row d-flex justify-content-center px-2"
                                  style={{ marginTop: "10px" }}
                                >
                                  <div className="col-md-3">
                                    <div className="main-card mb-3 card">
                                      <IonGrid>
                                        <IonRow className="d-flex">
                                          <IonCol size="auto">
                                            <div className="card-body p-3">
                                              <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content d-flex bounce-in">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
  
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkin}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date pe-4">
                                                        <p>Quy định vào</p>6 giờ
                                                        30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content bounce-in d-flex">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkout}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date">
                                                        <p>Quy định ra</p>5 giờ 30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </IonCol>
                                          <IonCol></IonCol>
                                        </IonRow>
                                      </IonGrid>
                                    </div>
                                  </div>{" "}
                                </div>
                                <div
                                  className="col-md-3 main-card card mb-0"
                                  style={{
                                    height: "201px",
                                    marginTop: "10px",
  
                                    background: "rgb(188 218 255)",
                                    width: "100%",
                                  }}
                                >
                                  <>
                                    {" "}
                                    <p className="d primary">Đ</p>
                                  </>
                                </div>
                              </div>
                            </li>
                          );
                        } else if (attendance.type == "2"  && attendance.date !=0) {
                          return (
                            <li
                              className="list-inline-item event-list w-100"
                              
                            >
                              <div className="event-date bg-soft-primary w-100 text-primary">
                                {attendance.day_of_week} (
                                {moment(attendance.date).format("DD-MM-YYYY")})
                              </div>
                              <div className="d-flex">
                                <div
                                  className="row d-flex justify-content-center px-2"
                                  style={{ marginTop: "10px" }}
                                >
                                  <div className="col-md-3">
                                    <div className="main-card mb-3 card">
                                      <IonGrid>
                                        <IonRow className="d-flex">
                                          <IonCol size="auto">
                                            <div className="card-body p-3">
                                              <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content d-flex bounce-in">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
  
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkin}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date pe-4">
                                                        <p>Quy định vào</p>6 giờ
                                                        30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content bounce-in d-flex">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkout}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date">
                                                        <p>Quy định ra</p>5 giờ 30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </IonCol>
                                          <IonCol></IonCol>
                                        </IonRow>
                                      </IonGrid>
                                    </div>
                                  </div>{" "}
                                </div>
                                <div
                                  className="col-md-3 main-card card mb-0"
                                  style={{
                                    height: "201px",
                                    marginTop: "10px",
                                    background: "rgb(188 218 255)",
                                    width: "100%",
                                  }}
                                >
                                  <>
                                    {" "}
                                    <p className="t">T</p>
                                  </>
                                </div>
                              </div>
                            </li>
                          );
                        } else if (attendance.type == "3" && attendance.date !=0) {
                          return (
                            <li
                              className="list-inline-item event-list w-100"
                           
                            >
                              <div className="event-date bg-soft-primary w-100 text-primary">
                                {attendance.day_of_week} (
                                {moment(attendance.date).format("DD-MM-YYYY")})
                              </div>
                              <div className="d-flex">
                                <div
                                  className="row d-flex justify-content-center px-2"
                                  style={{ marginTop: "10px" }}
                                >
                                  <div className="col-md-3">
                                    <div className="main-card mb-3 card">
                                      <IonGrid>
                                        <IonRow className="d-flex">
                                          <IonCol size="auto">
                                            <div className="card-body p-3">
                                              <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content d-flex bounce-in">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
  
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkin}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date pe-4">
                                                        <p>Quy định vào</p>6 giờ
                                                        30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div className="vertical-timeline-item vertical-timeline-element">
                                                  <div>
                                                    <span className="vertical-timeline-element-icon bounce-in">
                                                      <IonIcon
                                                        className="badge-dot-xl"
                                                        icon={cubeSharp}
                                                        size="large"
                                                        color="tertiary"
                                                      ></IonIcon>
                                                    </span>
                                                    <div className="vertical-timeline-element-content bounce-in d-flex">
                                                      <div
                                                        style={{
                                                          width: "100px",
                                                          height: "52px",
                                                          marginLeft: "10px",
                                                          padding: "10px",
                                                          backgroundColor:
                                                            "rgb(202 202 255)",
                                                          borderRadius: "10px",
                                                        }}
                                                        className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                      >
                                                        {attendance.checkout}
                                                      </div>
  
                                                      <div className="vertical-timeline-element-date">
                                                        <p>Quy định ra</p>5 giờ 30
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </IonCol>
                                          <IonCol></IonCol>
                                        </IonRow>
                                      </IonGrid>
                                    </div>
                                  </div>{" "}
                                </div>
                                <div
                                  className="col-md-3 main-card card mb-0"
                                  style={{
                                    height: "201px",
                                    marginTop: "10px",
                                    background: "rgb(188 218 255)",
                                    width: "100%",
                                  }}
                                >
                                  <>
                                    <p className="p">P</p>
                                  </>
                                </div>
                              </div>
                            </li>
                          );
                        } else if (attendance.type == "4" && attendance.date !=0) {
                          if (attendance.day_of_week == "Monday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                                
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 2 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Tuesday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 3 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Wednesday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 4 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Thursday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 5 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Friday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 6 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Saturday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 7 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Sunday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Chủ nhật (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  >
                                    <>
                                      {" "}
                                      <p className="k">K</p>
                                    </>
                                  </div>
                                </div>
                              </li>
                            );
                          }
                        } else {
                          if (attendance.day_of_week == "Monday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                               
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 2 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Tuesday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 3 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Wednesday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 4 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Thursday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 5 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Friday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                           
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 6 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Saturday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Thứ 7 (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                          if (attendance.day_of_week == "Sunday") {
                            return (
                              <li
                                className="list-inline-item event-list w-100"
                              >
                                <div className="event-date bg-soft-primary w-100 text-primary">
                                  Chủ nhật (
                                  {moment(attendance.date).format("DD-MM-YYYY")})
                                </div>
  
                                <div className="d-flex">
                                  <div
                                    className="row d-flex justify-content-center px-2"
                                    style={{ marginTop: "10px" }}
                                  >
                                    <div className="col-md-3">
                                      <div className="main-card mb-3 card">
                                        <IonGrid>
                                          <IonRow className="d-flex">
                                            <IonCol size="auto">
                                              <div className="card-body p-3">
                                                <div className="vertical-timeline p-0 vertical-timeline--animate vertical-timeline--one-column">
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content d-flex bounce-in">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
  
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkin}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date pe-4">
                                                          <p>Quy định vào</p>6 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div className="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                      <span className="vertical-timeline-element-icon bounce-in">
                                                        <IonIcon
                                                          className="badge-dot-xl"
                                                          icon={cubeSharp}
                                                          size="large"
                                                          color="tertiary"
                                                        ></IonIcon>
                                                      </span>
                                                      <div className="vertical-timeline-element-content bounce-in d-flex">
                                                        <div
                                                          style={{
                                                            width: "100px",
                                                            height: "52px",
                                                            marginLeft: "10px",
                                                            padding: "10px",
                                                            backgroundColor:
                                                              "rgb(202 202 255)",
                                                            borderRadius: "10px",
                                                          }}
                                                          className=" justify-content-center align-items-center d-flex text-dark fs-4"
                                                        >
                                                          {attendance.checkout}
                                                        </div>
  
                                                        <div className="vertical-timeline-element-date">
                                                          <p>Quy định ra</p>5 giờ
                                                          30
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </IonCol>
                                            <IonCol></IonCol>
                                          </IonRow>
                                        </IonGrid>
                                      </div>
                                    </div>{" "}
                                  </div>
                                  <div
                                    className="col-md-3 main-card card mb-0"
                                    style={{
                                      height: "201px",
                                      marginTop: "10px",
                                      background: "rgb(188 218 255)",
                                      width: "100%",
                                    }}
                                  ></div>
                                </div>
                              </li>
                            );
                          }
                        }
                      })}
                    </ul>
                  </div>
                </div>
  
                <IonCard>
                  <div className="text-center fw-bold fs-4">Ghi Chú</div>
                  <IonCardContent>
                    <IonItem>
                      <IonChip color="primary">Đ</IonChip>: Đầy đủ
                    </IonItem>
                    <IonItem>
                      <IonChip color="success">P</IonChip>: Vắng có phép
                    </IonItem>
                    <IonItem>
                      <IonChip color="warning">T</IonChip>: Diểm danh thiếu
                    </IonItem>
                    <IonItem>
                      <IonChip color="danger">K</IonChip>: Vắng không phép
                    </IonItem>
                  </IonCardContent>
                </IonCard>
              </div>
            </div>
          </div>
        </IonContent>
      </IonPage>
    );
  };
  
  export default AttendanceDiary;
  