import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router';
import PictureSourcSet from '../../component/atoms/Picture/SourceSet';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import { IGetImagePreview } from '../../props/props';

const GetPreviewImage: React.FC<React.PropsWithChildren<IGetImagePreview>> = (
  props: IGetImagePreview,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/images/image/${props.id}`);
      response = await response.json();
      setAppState(response);
      setLoading(false);
    }

    fetchMyApi();
  }, [setAppState, props]);
  if (loading || appState === null) {
    return <LoadingAlertBox />;
  }

  if (props.id === 0 || props.id === null) {
    return <></>;
  }

  return (
    <div>
      <PictureSourcSet
        img={appState.images.img}
        images={appState.images.images}
        alt={appState.images.alttext}
      />
      {appState.images.bildtext !== '' ? <span>{appState.images.bildtext}</span> : ''}
    </div>
  );
};
export default GetPreviewImage;
