import {
  IonButtons,
  IonContent,
  IonHeader,
  IonImg,
  IonItem,
  IonPage,
  IonTitle,
  IonToolbar,
} from "@ionic/react";
// import { useParams } from "react-router";
// import ExploreContainer from "../components/ExploreContainer";
import "./Opinion.css";
import { IonBackButton } from "@ionic/react";
 
//   import { IonIcon } from "@ionic/react";
// import { IonReactRouter } from "@ionic/react-router";
// import { Link, Redirect, Route } from "react-router-dom";
// import Menu from "../components/Menu";
//   import { cubeSharp } from "ionicons/icons";

const OpinionDetail: React.FC = () => {
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
            {/* <IonMenuButton /> */}
            <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Chi tiết góp ý</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent className="container">
        <IonItem style={{ marginTop: "10px" }}>
          <div className=" border-bottom bg-white rounded-4 p-1 mb-3">
            <div className="d-flex align-items-center gap-3 ">
              <div className="d-flex flex-column gap-2 ">
                <p className="mb-0 fs-5 fw-bold">
                  Tình hình bạo lực học đường công ty TNHH Eclo
                </p>
                <div className="fw-bold fs-6 text-start text-secondary">
                  11-01-2023 (11:30)
                </div>

                <div className=" fs-6" style={{ textAlign: "justify" }}>
                  <IonImg
                    src="https://docs-demo.ionic.io/assets/madison.jpg"
                    alt="The Wisconsin State Capitol building in Madison, WI at night"
                    style={{ marginBottom: "10px" }}
                  ></IonImg>
                  1. Thế nào là bạo lực học đường: Bạo lực học đường là những
                  hành vi thô bạo, thiếu đạo đức với bạn mình. Cách cư xử thiếu
                  văn minh, không có giáo dục của thế hệ học sinh. Xúc phạm đến
                  tinh thần và thể xác người khác, gây ảnh hưởng nghiêm trọng.
                  Hành vi này càng ngày càng phổ biến. 2. Hiện trạng của bạo lực
                  học đường hiện nay: Lăng mạ, xúc phạm, chửi bậy đối với người
                  khác. Làm tổn thương đến tinh thần bạn bè. Học sinh có thái độ
                  không đúng với thầy cô. Thầy cô xúc phạm đến học sinh. Lập các
                  bang nhóm đánh nhau ở học sinh. 3. Nguyên nhân dẫn đến hiện
                  tượng bạo lực học đường: Do ảnh hưởng của môi trường bạo lực,
                  thiếu văn hóa. Chưa có sự quan tâm từ gia đình. Không có sự
                  giáo dục đúng đắn của nhà trường. Xã hội dửng dưng trước những
                  hành động bạo lực. Sự phát triển chưa toàn diện của học sinh.
                  4. Hậu quả của bạo lực học đường: a. Với người bị bạo lực: Bị
                  ảnh hưởng về tinh thần và thể chất. Làm cho gia đình họ bị đau
                  thương. Làm cho xã hội bất ổn. b. Với người gây ra bạo lực:
                  Phát triển không toàn diện. Mọi người chê trách. Mất hết tương
                  lai, sự nghiệp. 5. Cách khắc phục nạn bạo lực học đường: Nhà
                  trường cần nâng cao nhận thức và dạy bảo học sinh hiệu quả
                  nhất. Cha mẹ nên chăm lo và quan tâm đến con cái. Tự bản thân
                  có trách nhiệm xa lánh tình trạng bạo lực học đường.
                </div>
              </div>
            </div>
          </div>
        </IonItem>
      </IonContent>
      {/* <FooterBar></FooterBar> */}
    </IonPage>
  );
};

export default OpinionDetail;
