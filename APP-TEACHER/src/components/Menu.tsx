import {
  IonButton,
  IonContent,
  IonIcon,
  IonItem,
  IonLabel,
  IonList,
  IonListHeader,
  IonMenu,
  IonMenuToggle,
  IonNote,
  IonRow,
} from "@ionic/react";
import { Link, useHistory } from "react-router-dom";
import { useLocation } from "react-router-dom";
// import { getToken, removeUserSession, setUserSession } from "../pages/Common";
import {
  archiveOutline,
  archiveSharp,
  bookmarkOutline,
  heartOutline,
  heartSharp,
  mailOutline,
  mailSharp,
  paperPlaneOutline,
  paperPlaneSharp,
  trashOutline,
  trashSharp,
  warningOutline,
  warningSharp,
  homeOutline,
  homeSharp,
  alarmOutline,
  alarmSharp,
  layersOutline,
  layersSharp,
  backspaceOutline,
  backspaceSharp,
  schoolOutline,
  schoolSharp,
  busOutline,
  busSharp,
  notificationsOutline,
  notificationsSharp,
  personCircleOutline,
  personCircleSharp,
  golfOutline,
  golfSharp,
  receiptOutline,
  receiptSharp,
} from "ionicons/icons";
import "./Menu.css";
import {
  createOutline,
  createSharp,
  fitnessOutline,
  fitnessSharp,
  calendarOutline,
  calendarSharp,
  brushOutline,
  brushSharp,
  peopleOutline,
  peopleSharp,
  personOutline,
  personSharp,
  printOutline,
  printSharp,
  calculatorOutline,
  calculatorSharp,
} from "ionicons/icons";
import { useEffect, useState } from "react";
import axios from "axios";

interface AppPage {
  url: string;
  iosIcon: string;
  mdIcon: string;
  title: string;
}

const appPages: AppPage[] = [
  // {
  //   title: 'HealthRecord',
  //   url: '/HealthRecord',
  //   iosIcon: warningOutline,
  //   mdIcon: warningSharp
  // },
  {
    title: "Trang chủ",
    url: "/dashboard",
    iosIcon: homeOutline,
    mdIcon: homeSharp,
  },
  {
    title: "Điểm danh học sinh",
    url: "/attendance",
    iosIcon: alarmOutline,
    mdIcon: alarmSharp,
  },
  {
    title: "Kết quả học tập",
    url: "/scores",
    iosIcon: brushOutline,
    mdIcon: brushSharp,
  },
  {
    title: "Lịch dạy học",
    url: "/schedule",
    iosIcon: calendarOutline,
    mdIcon: calendarSharp,
  },
  {
    title: "Sổ đầu bài",
    url: "/noteBook",
    iosIcon: receiptOutline,
    mdIcon: receiptSharp,
  },
  {
    title: "Giáo án",
    url: "/lessionPlan",
    iosIcon: golfOutline,
    mdIcon: golfSharp,
  },
  // {
  //   title: 'Nề nếp thi đua',
  //   url: '/routine',
  //   iosIcon: golfOutline,
  //   mdIcon: golfSharp
  // },
  {
    title: "Thực đơn",
    url: "/meals",
    iosIcon: layersOutline,
    mdIcon: layersSharp,
  },
  // {
  //   title: 'Xin nghỉ phép',
  //   url: '/leave',
  //   iosIcon: backspaceOutline,
  //   mdIcon: backspaceSharp
  // },
  {
    title: "Hồ sơ sức khỏe",
    url: "/healthRecord",
    iosIcon: fitnessOutline,
    mdIcon: fitnessSharp,
  },
  {
    title: "Hoạt động trường",
    url: "/news",
    iosIcon: schoolOutline,
    mdIcon: schoolSharp,
  },
  {
    title: "Danh sách học sinh",
    url: "/listStudent",
    iosIcon: personCircleOutline,
    mdIcon: personCircleSharp,
  },
  {
    title: "Danh sách giáo viên",
    url: "/Teacher",
    iosIcon: peopleOutline,
    mdIcon: peopleSharp,
  },
  {
    title: "Thông tin tài khoản",
    url: "/Account",
    iosIcon: personOutline,
    mdIcon: personSharp,
  },
  {
    title: "Tra cứu công nợ",
    url: "/Debt",
    iosIcon: printOutline,
    mdIcon: printSharp,
  },
  {
    title: "Sổ thu chi",
    url: "/Cash",
    iosIcon: calculatorOutline,
    mdIcon: calculatorSharp,
  },
  {
    title: "Đưa đón học sinh",
    url: "/Move",
    iosIcon: busOutline,
    mdIcon: busSharp,
  },

  {
    title: "Nhật ký điểm danh",
    url: "/AttendanceTeacher",
    iosIcon: createOutline,
    mdIcon: createSharp,
  },
  {
    title: "Thông báo giáo viên",
    url: "/notificationTeacher",
    iosIcon: notificationsOutline,
    mdIcon: notificationsSharp,
  },
  {
    title: "Thông báo",
    url: "/notifications",
    iosIcon: notificationsOutline,
    mdIcon: notificationsSharp,
  },
  {
    title: "Thông báo từ phụ huynh",
    url: "/notificationParent",
    iosIcon: notificationsOutline,
    mdIcon: notificationsSharp,
  },
  {
    title: "Ghi chú",
    url: "/note",
    iosIcon: calculatorOutline,
    mdIcon: calculatorSharp,
  },
];

const labels = ["Family", "Friends", "Notes", "Work", "Travel", "Reminders"];

const Menu: React.FC = () => {
  const location = useLocation();
  const history = useHistory();
  const handleLogout = () => {
    const removeUserSession = () => {
         localStorage.removeItem('token');
       }
    removeUserSession();
    window.location.href = "/";
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

  return (
    <IonMenu contentId="main" type="overlay">
      <IonContent>
        <IonList id="inbox-list">
          {teacher.map((teacher, key) => {
            return (
              <IonListHeader>
                {teacher.firstname} {teacher.lastname}
              </IonListHeader>
            );
          })}

          <IonNote>Mã GV: {ma}</IonNote>
          {appPages.map((appPage, index) => {
            return (
              <IonMenuToggle key={index} autoHide={false}>
                <Link to={appPage.url} style={{ textDecoration: "none" }}>
                <IonItem
                  className={
                    location.pathname === appPage.url ? "selected" : ""
                  }
                  // routerLink={appPage.url}
                  routerDirection="none"
                  lines="none"
                  detail={false}
                >
                  <IonIcon
                    aria-hidden="true"
                    slot="start"
                    ios={appPage.iosIcon}
                    md={appPage.mdIcon}
                  />
                  <IonLabel>{appPage.title}</IonLabel>
                </IonItem>
                </Link>
              </IonMenuToggle>
            );
          })}
        </IonList>

        <IonRow className="justify-content-center mt-4 d-flex">
          {/* <IonButton className='w-50'  color="dark">ĐĂNG XUẤT</IonButton> */}
          <input
            type="button"
            className="w-50 bg-danger text-white p-2 fw-bold rounded-3"
            onClick={handleLogout}
            value="ĐĂNG XUẤT"
          />
        </IonRow>
      </IonContent>
    </IonMenu>
  );
};

export default Menu;
