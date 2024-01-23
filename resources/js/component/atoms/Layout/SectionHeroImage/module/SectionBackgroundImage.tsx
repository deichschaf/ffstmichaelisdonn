import React from 'react';
import { SectionHeroImageProps } from '../../../../../props/props';
import ErrorBoundary from '../../../../organisms/errorboundary';

const SectionBackgroundImage: React.FC<React.PropsWithChildren<SectionHeroImageProps>> = (
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
  const path = '/grfx/';
  let position = '50% 50%';
  let image = 'ponyschule.jpg';

  if (typeof images.image !== 'undefined') {
    if (images.image !== null && images.image !== '') {
      image = images.image;
    }
  }

  if (typeof images.position !== 'undefined') {
    if (images.position !== null && images.position !== '') {
      position = images.position;
    }
  }

  const sectionStyle = {
    backgroundImage: `url(${path}${image})`,
    backgroundPosition: position,
  };

  return (
    <ErrorBoundary>
      <section className="hero_area" style={sectionStyle} />
    </ErrorBoundary>
  );
};
export default SectionBackgroundImage;
