import React from 'react';
import { SectionHeroImageProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import SectionBackgroundImage from './module/SectionBackgroundImage';
import SectionPictureResize from './module/SectionPictureResize';

const SectionHeroImage: React.FC<React.PropsWithChildren<SectionHeroImageProps>> = (
  props: SectionHeroImageProps
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page.headimages === 'undefined') {
    return <></>;
  }
  const images = props.pagedata.page.headimages;

  return (
    <ErrorBoundary>
      <>
        {images.image !== undefined ? <SectionBackgroundImage pagedata={props.pagedata} /> : <></>}
        {images.image === undefined ? <SectionPictureResize pagedata={props.pagedata} /> : <></>}
      </>
    </ErrorBoundary>
  );
};
export default SectionHeroImage;
