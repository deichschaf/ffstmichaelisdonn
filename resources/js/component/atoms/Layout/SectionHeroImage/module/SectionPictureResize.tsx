import React from 'react';
import { SectionHeroImageProps } from '../../../../../props/props';
import ErrorBoundary from '../../../../organisms/errorboundary';
import PictureSourcSet from '../../../Picture/SourceSet';

const SectionPictureResize: React.FC<React.PropsWithChildren<SectionHeroImageProps>> = (
  props: SectionHeroImageProps,
): JSX.Element => {
  if (typeof props.pagedata.page === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page.headimages === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page.headimages.img === 'undefined') {
    return <></>;
  }
  const images = props.pagedata.page.headimages;

  return (
    <ErrorBoundary>
      <section>
        <PictureSourcSet
          className="picture"
          img={images.img}
          images={images.images}
          path="/grfx/rotation/"
        />
      </section>
    </ErrorBoundary>
  );
};

export default SectionPictureResize;
