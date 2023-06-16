
import { useParams } from "react-router";
import {IonCol,IonBackButton, IonButton,IonGrid, IonRow, IonCard,IonPage,IonHeader,IonToolbar,IonButtons,IonMenuButton,IonTitle,IonContent, IonCardContent, IonCardHeader, IonCardSubtitle, IonCardTitle } from '@ionic/react';
import {

} from "ionicons/icons";
import "./Profile_dad.css";
const Page: React.FC = () => {
  
  return (
    <IonPage>
      <IonHeader>
        <IonToolbar>
          <IonButtons slot="start">
             <IonBackButton></IonBackButton>
          </IonButtons>
          <IonTitle>Thông tin phụ huynh</IonTitle>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen className="box_content">
      <article className="bg-xl2 h-100 pb-1">
        <div className="before-bgdad-style">
          <div className="profile">
            <div className="avatar">
              <img className="avatar-img" src="https://toquoc.mediacdn.vn/2019/9/5/001a3513-15676514560451166952689.jpg" alt="" />
            </div>
            <IonCardContent className="bg-3 ms-0 me-0 profile ps-2">
            <IonGrid className="pv2">
                <IonRow className="pt-4">
                  <IonCol className="text-2">Quan hệ:</IonCol>
                  <IonCol className="text-1" size="7">Mẹ</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Họ và tên:</IonCol>
                  <IonCol className="text-1" size="7">Nguyễn Thị Thanh An</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Ngày sinh:</IonCol>
                  <IonCol className="text-1" size="7">17/08/2000</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Dân tộc:</IonCol>
                  <IonCol className="text-1" size="7">Kinh</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Số điện thoại:</IonCol>
                  <IonCol className="text-1" size="7">0372440222</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Gmail:</IonCol>
                  <IonCol className="text-1" size="7">ly@eclo.vn</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Nghề nghiệp:</IonCol>
                  <IonCol className="text-1" size="7">Nội trợ</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Tôn giáo:</IonCol>
                  <IonCol className="text-1" size="7">Phật giáo</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Nơi sinh:</IonCol>
                  <IonCol className="text-1" size="7">An Giang</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Quố tịch:</IonCol>
                  <IonCol className="text-1" size="7">Việt Nam</IonCol>
                </IonRow>
                <IonRow className="pt-3">
                  <IonCol className="text-2">Địa chỉ thường trú:</IonCol>
                  <IonCol className="text-1" size="7">54 Bầu Cát 6 Tân Bình TPHCM</IonCol>
                </IonRow>
              </IonGrid>
              <IonCardTitle className="fw-1 p-2"></IonCardTitle>
          </IonCardContent>
          </div>
        </div>
       
      </article>
     
      </IonContent>
    </IonPage>
  );
};

export default Page;
