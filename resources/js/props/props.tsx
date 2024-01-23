import React, { ChangeEventHandler, HTMLAttributes, HTMLProps, MouseEventHandler } from 'react';
import { LatLngLiteral, LatLngTuple } from 'leaflet';
import Colors from '../component/types/colors';

export interface ISaveInfoErrorProps {
  responseText?: string | undefined;
  errorText?: string | undefined;
}

export interface ILayoutMainContentProps {
  children?: any | undefined;
  pagedata?: any | undefined;
  widget?: any | undefined;
  warnings?: any | undefined;
}

export interface IAsideContactProps {
  pagedata?: any | undefined;
}

export interface ILayoutContainerProps {
  children?: any | undefined;
}

export interface ISectionHeroImageProps {
  pagedata?: any | undefined;
}

export interface IHomepageProps {
  homepage_owner?: string | undefined;
}

export interface IButtonAddLineProps {
  url?: string | undefined;
}

export interface IButtonLineProps {
  url?: string | undefined;
  icon?: string | undefined;
  title?: string | undefined;
}

export interface TypoProps {
  className?: string | undefined;
  label?: string | number | undefined;
  id?: string | undefined;
  children?: any | undefined;
}

export interface IFAProps {
  className?: string;
  title?: string;
}

export interface IStatisticBoxAreaProps {
  data?: any | undefined;
}

export interface IStatisticBoxProps {
  linkText?: string | undefined;
  link?: string | undefined;
  text?: string | undefined;
  lastalarm?: string | undefined;
  title?: string | undefined;
  symbol?: string | undefined;
}

export interface ILinkProps {
  href?: string | undefined;
  className?: string | undefined;
  rel?: string | undefined;
  target?: string | undefined;
  title?: string | undefined;
  children?: any | undefined;
  onClick?: (e: React.MouseEvent<HTMLAnchorElement, MouseEvent>) => void;
}

export interface ICountdownProps {
  datetime?: string | undefined;
  text?: string | undefined;
  label?: string | undefined;
}

export type IH1Props = TypoProps;
export type IH2Props = TypoProps;
export type IH3Props = TypoProps;
export type IH4Props = TypoProps;
export type IH5Props = TypoProps;
export type IH6Props = TypoProps;
export type IH7Props = TypoProps;
export type IPProps = TypoProps;

export interface ILabelProps {
  htmlFor?: string | undefined;
  className?: string | undefined;
  label?: string | undefined;
}

export interface ILabelInputComponentProps extends ILabelProps, IInputProps {
  labelClassName?: string | undefined;
  setParentValue: (arg: string | number) => void;
}

export interface ILabelTextareaComponentProps extends ILabelProps, ITextareaProps {
  labelClassName?: string | undefined;
  setParentValue: (arg: string | number) => void;
}

export interface IAuthProps {
  middleware?: string | undefined;
  redirectIfAuthenticated?: string | undefined;
  token?: string | undefined;
}

export interface ILoginPageProps {
  reset?: string | undefined;
}

export interface IForgotPasswordProps {}

export interface IRegisterProps {}

export interface IVerifyEmailProps {}

export interface IPasswordResetProps {
  token?: string | undefined;
  email?: string | undefined;
}

export interface IStyleProps {
  style?: string | undefined;
}

export interface IAriaProps {
  ariaValuenow?: string | number | undefined;
  ariaValuemin?: string | number | undefined;
  ariaValuemax?: string | number | undefined;
}

export interface IDataProps {
  qa?: string | undefined;
  dataDismiss?: string | undefined;
  dataQa?: string | undefined;
  slug?: string | undefined;
  data?: any | undefined;
  params?: any | undefined;
  children?: any | undefined;
}

export interface IRefProps {
  ref?: string | undefined;
}

export interface IRoleProps {
  role?: string | undefined;
}

export interface ISpacerProps {
  label?: string | undefined;
  paragraph?: boolean | string | undefined | number;
}

type IDIVProps = HTMLProps<HTMLElement> & HTMLAttributes<HTMLElement>;

export interface ChartJProps {
  data?: any | never | undefined;
  legende?: any | never | undefined;
  label?: string | never | number | undefined;
}

export type IStatisticPieProps = ChartJProps;
export type IStatisticHoriziontalBarProps = ChartJProps;
export type IStatisticLineProps = ChartJProps;
export type IStatisticVerticalBarProps = ChartJProps;

export interface IPageData {
  page?: string | undefined;
  pagedata?: any | undefined;
  children?: any | undefined;
}

export type IPageContainerProps = IPageData;

export interface IStartpageComponentProp extends IPageData {
  formurl?: string | undefined;
  xtoken?: string | undefined;
  downloads?: any | undefined;
}

export interface IPageOverviewRootListProps {
  pages: any;
  deletepath?: string | undefined;
  editpath?: string | undefined;
  editheadlinepath?: string | undefined;
  upage?: any | undefined;
  contentTypeId?: number | undefined;
  id?: number | undefined;
  pagecontenttypes?: any | undefined;
}

export interface IPageOverviewSecondListProps {
  deletepath?: string | undefined;
  editpath?: string | undefined;
  editheadlinepath?: string | undefined;
  upages?: any | undefined;
  pagecontenttypes?: any | undefined;
}

export type IPageOverviewFourthListProps = IPageOverviewSecondListProps;

export type IPageOverviewThirtListProps = IPageOverviewSecondListProps;

export interface IPageAddEditComponentProps {}

export interface IPageAddEditHeadlineComponentProps {}

export type IPageComponentProps = IPageData;

export interface IPageOverviewComponentProps {}

export interface IGridBoxProps extends IGridSimpleProps {
  children?: any | undefined;
}

export interface IPageOverviewRootProps {
  pagecontenttypes?: any | undefined;
  deletepath?: string | undefined;
  editpath?: string | undefined;
  editheadlinepath?: string | undefined;
  systempage?: boolean;
  contentTypeId?: number | undefined;
  id?: number | undefined;
  contentType?: string | undefined;
  title?: string | undefined;
  page?: any | undefined;
  upages?: any | undefined;
}

export interface IPageContentTypeProps {
  contentTypeId?: number | undefined;
  contentType?: string | undefined;
  pagecontenttypes?: any | undefined;
}

export interface IUnwetterInfoProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface IHappyHolidayProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface IDanceBallProps {
  datetime?: string | undefined;
  showuntil?: string | undefined;
  children?: any | undefined;
  data?: any | undefined;
}

export interface IAnnualGeneralMeetingProps {
  datetime?: string | undefined;
  showuntil?: string | undefined;
  children?: any | undefined;
  data?: any | undefined;
}

export interface IFlyerboxProps {
  datetime?: string | undefined;
  showuntil?: string | undefined;
  children?: any | undefined;
  data?: any | undefined;
}

export interface ICriticalMessageProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface IBloodDonationTermineProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface IRowHeadlineProps {
  label?: string | number | undefined;
  headlineSize?: string | undefined;
}

export interface IWeatherMessageProps {
  data?: any | undefined;
}

export interface IEinsaetzeProps {
  begin?: string | undefined;
  end?: string | undefined;
  cars?: any | undefined;
}

export interface IEinsatzMelderProps {
  begin?: string | undefined;
  end?: string | undefined;
  children?: any | undefined;
  cars?: any | undefined;
  key?: string | undefined;
  id?: number | string | undefined;
  data?: any | undefined;
}

export interface IRescueEliminateBailSaveProps {}

export interface IHydrantCheckInfoProps {
  data?: any | undefined;
}

export interface IReadyForUseProps {}

export interface IDireStraitsProps {}

export interface IPaulinchenTdbKProps {}

export interface IFooterSocialMediaProps {
  footer?: any | undefined;
}

export interface IFooterContactProps {
  footer?: any | undefined;
}

export interface IFooterEmergencyProps {
  data?: any | undefined;
}

export interface IWidgetTermineProps {
  data?: any | undefined;
}

export interface INotrufProps {}

export interface IPhoneNumberProps {
  telephonenumber?: string | number | undefined;
  children?: any | undefined;
}

export interface IStatusInActiveProps {
  status: boolean | string;
}

export interface IPhotoInformationProps {
  img?: string | undefined;
  images?: any | undefined;
  fotograph?: string | undefined;
  title?: string | undefined;
  description?: string | undefined;
}

export interface IVehicleProcessProps {
  data: any;
}

export interface IVehicleProcessOverviewProps {
  stationiert: any;
}

export interface IFooterServiceProps {
  footer?: any | undefined;
}

export interface IFooterContentProps {
  footer?: any | undefined;
}

export interface IEmergencyAlarmMailMessageProps {
  getAlarmEmailId?: number | undefined;
  getAlarmMailResponse?: object | any | string | undefined;
}

export interface IEmergencyListProps {
  key?: string | number | any | undefined;
  value?: string | any | object | number | undefined;
  count?: string | number | undefined;
  idx?: number | undefined;
}

export interface IEmergencyListEntryProps {
  key?: string | number | any | undefined;
  value?: string | any | object | number | undefined;
  count?: string | number | undefined;
  idx?: number | undefined;
}

export interface IEmergencyAlarmMailMessageRowEntryProps {
  keyname?: string | undefined;
  value?: string | any | object | number | undefined;
  count?: string | number | undefined;
}

export interface IEmergencyGetKoorginatesProps {
  address?: string | undefined;
}

export interface IAnwesenheitOverviewProps extends IPageData {
  id?: number | undefined;
}

export interface IEinsatzOverviewProps extends IPageData {
  jahr?: number | undefined;
}

export interface IEmergencyAreaMapProps {
  areas?: any | undefined;
  data?: any | undefined;
}

export interface IEinsatzgebietProps extends IPageData {
  id?: number | undefined;
}

export interface IEinsatzDetailProps extends IPageData {
  id?: number | undefined;
}

export interface IFiretruckOverviewProps extends IPageData {
  id?: number | undefined;
}

export interface IFiretruckOverviewComponentProps extends IPageData {
  id?: number | undefined;
  data?: any | undefined;
  image?: any | undefined;
}

export interface IFiretruckOverviewDataProps extends IPageData {
  data?: any | undefined;
}

export interface IFireTruckImageProps extends IPageData {
  id?: number | string | undefined;
  data?: any | undefined;
}

export interface IFiretruckDetailProps extends IPageData {
  id?: number | undefined;
}

export interface IFireDepartmentManagementProps {
  data?: any | undefined;
}

export interface IOrganisationStationProps {
  organisation: string;
  stations: any;
}

export interface IOrganisationHeadlineProps {
  headline: string;
}

export interface IStationCardProps {
  data?: any | undefined;
  organisation?: string | undefined;
}

export interface IVehicleCardProps {
  data?: any | undefined;
}

export interface IFireDepartmentUserProps extends IFireDepartmentUserAdressProps {
  data?: any | undefined;
}

export interface IAdress {
  street?: string | undefined;
  housenumber?: string | undefined;
  zipcode?: number | undefined;
  city?: string | undefined;
  telephonenumber?: string | undefined;
  mobilnumber?: string | undefined;
  telefaxnumber?: string | undefined;
  emailadress?: string | undefined;
}

export interface IFireDepartmentUserAdressProps extends IAdress {
  id?: string | number | undefined;
}

export interface IFireDepartmentUserPictureProps extends AllPictureProps {
  data?: any | undefined;
}

export type IEmergencyMapProps = IMapProps;

export interface IMapProps {
  lat?: LatLngLiteral | LatLngTuple | number | undefined;
  lon?: LatLngLiteral | LatLngTuple | number | undefined;
  popup?: string | any | undefined;
}

export interface IStartpageComponentState {
  formurl?: string | undefined;
  xtoken?: string | undefined;
  downloads?: any | undefined;
}

export interface ILocationProps {
  location?: any | undefined;
}

export interface IBlackdayProps {
  data?: any | undefined;
  children?: any | undefined;
  pagedata?: any | undefined;
}

export interface IBlackdayMessageProps extends IHomepageProps {
  data?: any | undefined;
}

export interface ISelectProps {
  name?: string | undefined;
  id?: string | undefined;
  selected?: boolean | undefined;
  value?: string | undefined;
  className?: string;
  input?: any | undefined;
  options?: any | undefined;
  onChange?: ChangeEventHandler<HTMLInputElement>;
}

export interface IReactSelectProps extends AllFormProps {
  closeMenuOnSelect?: boolean | undefined;
  components?: React.ReactNode | undefined;
}

export interface ICheckboxProps
  extends Omit<React.InputHTMLAttributes<HTMLInputElement>, 'onChange'> {
  name?: string | undefined;
  id?: string | undefined;
  checked?: boolean | undefined;
  value?: string | undefined;
  className?: string;
  onClick: (event?: React.MouseEvent<HTMLInputElement>) => void;
  label?: string;
}

export interface IDivCheckboxProps {
  name?: string | undefined;
  id?: string | undefined;
  checked?: boolean | undefined;
  value?: string | undefined;
  className?: string;
  label?: string;
  setParentValue: (arg: boolean) => void;
}

export interface SwitchProps {
  component?: string | undefined;
  className?: string | undefined;
}

export interface DownloadProps {
  download?: string | undefined;
}

export interface IAdminOverviewListProps {
  url: string;
  headline?: string | undefined;
}

export interface IDashboardProps {
  title?: string | undefined;
}

export interface IAdminStatisticProps {
  statistic?: any | undefined;
  title?: string | undefined;
  className?: string | undefined;
  count?: number | string | undefined;
  count_comma?: number | string | undefined;
  count_max?: number | string | undefined;
  percent?: number | string | undefined;
  color?: string | undefined;
}

export interface IAdminOverviewPageProps {
  label?: string | undefined;
  url?: string | undefined;
}

export interface TypeProps {
  type?: string | undefined;
  className?: string | undefined;
}

export interface DropzoneProp {
  name?: string | undefined;
}

export interface IGetImagePreview {
  id?: number | undefined;
}

export interface IAllPictureProps {
  className?: string | undefined;
  path?: string | undefined;
  img?: string | undefined;
  alt?: string | undefined;
  title?: string | undefined;
  srcset?: any | undefined;
  images?: any | undefined;
  type?: string | undefined;
}

export interface IHeaderProps {
  header?: any | undefined;
  mainnavi?: any | undefined;
  data?: any | undefined;
}

export interface IHeaderTitleContactProps {
  header?: any | undefined;
}

export type IHeaderInstagramProps = IHeaderSocialMediaItemProps;
export type IHeaderFacebookProps = IHeaderSocialMediaItemProps;
export type IHeaderEmailProps = IHeaderSocialMediaItemProps;
export type IHeaderPhoneProps = IHeaderSocialMediaItemProps;
export type IHeaderYoutubeProps = IHeaderSocialMediaItemProps;

export interface IHeaderSocialMediaProps {
  social?: any | undefined;
}

export interface IHeaderSocialMediaItemProps {
  name?: string | undefined;
  url?: string | undefined;
  phonenumber?: string | undefined;
  phonenumber_click?: string | undefined;
  show_icon?: boolean;
}

export interface INewsProps {}

export interface ISVGIconProps {
  svg?: string | undefined;
  title?: string | undefined;
  alt?: string | undefined;
  className?: string | undefined;
}

export interface IAdminHeaderProps {
  header?: any | undefined;
  mainnavi?: any | undefined;
}

export interface IAdminHeadlineProps {
  label?: string | undefined;
}

export interface IFooterProps {
  footer?: any | undefined;
  footerlinks?: any | undefined;
  data?: any | undefined;
}

export type IFooterModulesProps = IFooterProps;
export type IFooterFlodithStatisticProps = IFooterProps;

export interface IBackToTopProps {
  label?: string;
  onClick?: MouseEventHandler<HTMLButtonElement>;
}

export interface ISocialBarProps {
  data?: any | undefined;
  showbar?: boolean | undefined;
  showfacebook?: boolean | undefined;
  showinstagram?: boolean | undefined;
  showlinkedin?: boolean | undefined;
  showtwitter?: boolean | undefined;
  showyoutube?: boolean | undefined;
  showpinterest?: boolean | undefined;
}

export interface IPageAdminContainerProps {
  children?: any | undefined;
}

export interface IPageAppContainerProps {
  children?: any | undefined;
}

export interface IPageAppWrapperProps {
  children?: any | undefined;
  footer?: any | undefined;
  header?: any | undefined;
  location?: any | undefined;
}

export interface IErrorBoundrayProps {
  children?: any | undefined;
}

export interface IPageWrapperProps {
  search_value?: any | undefined;
  children?: any | undefined;
  footer?: any | undefined;
  header?: any | undefined;
  sociallinks?: any | undefined;
  data?: any | undefined;
  pagedata?: any | undefined;
  warnings?: any | undefined;
}

export interface IPageAdminWrapperProps {
  children?: any | undefined;
  footer?: any | undefined;
  header?: any | undefined;
  location?: any | undefined;
}

export interface IAdminNavigationProps {
  links?: any | undefined;
  location?: any | undefined;
}

export interface IFooterNavigationProps {
  footerlinks?: any | undefined;
}

export interface ILogoProps {
  path?: string | undefined;
  alt?: string | undefined;
  url?: string | undefined;
}

export interface ICoronaTermineProps {}

export interface ITermineVorbehaltProps {}

export interface ITermineEntryProps {
  sign?: string | undefined;
  date?: string | undefined;
  time?: string | undefined;
  termin?: string | undefined;
  place?: string | undefined;
  description?: string | undefined;
  clothes?: string | undefined;
}

export interface ITermineProps {
  children?: any | undefined;
  date?: string | undefined;
  begin?: string | undefined;
  end?: string | undefined;
  description?: string | undefined;
  place?: string | undefined;
}

export interface ILogoWithNameProps extends ILogoProps {
  name: string;
}

export interface ILogoWithoutTitleProps extends ILogoProps {
  name?: string | undefined;
}

export interface IStartPageProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface IPageProps {
  children?: any | undefined;
  data?: any | undefined;
}

export interface INewsBoxesProps {
  data?: any | undefined;
}

export interface INewsBoxProps {
  data?: any | undefined;
}

export interface INewsBoxFloDithProps {
  data?: any | undefined;
}

export interface IMoreLinkProps {
  url?: string | undefined;
}

export interface IFireDepartmentStatisticProps {
  active_user?: number | undefined;
  trucks?: number | undefined;
  alarms?: number | undefined;
  alarms_this_year?: number | undefined;
  alarms_last_year?: number | undefined;
}

export interface IEmergencyMonthStatisticProps {
  data?: any | undefined;
}

export interface IFireDepartmentFieldTypeProps {
  color?: string | undefined;
  percent?: number | undefined;
  name?: string | undefined;
}

export interface IFireDepartmentFieldTypeDataProps {
  jahr?: number | undefined;
  y;
  data?: any | undefined;
}

export interface IFireDepartmentFireRegisterProps extends IDataProps {
  href?: string | undefined;
}

export type IContactFormInfoLineProps = IDataProps;

export type IContentEmergencyFireRegisterProps = IDataProps;

export interface ICountUpWithIconProps {
  maxcount?: number | undefined;
  startcount?: number | undefined;
  description?: string | undefined;
  icon?: string | undefined;
  icontype?: string | undefined;
  id?: string | undefined;
}

export interface IHeaderNavigationProps {
  mainnavi?: any | undefined;
}

export interface IHeaderNavLinkProps {
  title?: string | undefined;
  link?: string | undefined;
  target?: string | undefined;
  rel?: string | undefined;
  id?: number | undefined;
  subnavi?: any | undefined;
  options?: any | undefined;
}

export interface IHeaderNavDropdownProps {
  title?: string | undefined;
  link?: string | undefined;
  target?: string | undefined;
  rel?: string | undefined;
  id?: number | undefined;
  subnavi?: any | undefined;
  options?: any | undefined;
}

export interface IHeaderNavTypeProps {
  title?: string | undefined;
  link?: string | undefined;
  target?: string | undefined;
  rel?: string | undefined;
  id?: number | undefined;
  subnavi?: any | undefined;
  options?: any | undefined;
}

export interface IHeaderMainNaviItemProps {
  title?: string | undefined;
  subnavi?: string | undefined;
}

export interface IHeaderMainNaviSubItemProps {
  title?: string | undefined;
  url?: string | undefined;
  target?: string | undefined;
}

export interface IGridColProps {
  children?: any | undefined;
  key?: number | undefined;
  id?: string | undefined;
  xxl?: number | string | undefined;
  xl?: number | string | undefined;
  lg?: number | string | undefined;
  md?: number | string | undefined;
  sm?: number | string | undefined;
  xs?: number | string | undefined;
  className?: string | undefined;
}

export interface IGridRowProps {
  className?: string | undefined;
  key?: number | undefined;
  id?: string | undefined;
  children?: any | undefined;
}

export interface IIconSetProps {
  className?: string | undefined;
  key?: number | undefined;
  id?: string | undefined;
  children?: any | undefined;
  title?: any | undefined;
}

export interface IHeaderImageProps {
  data?: any | undefined;
}

export interface IBreadcrumbProps {
  links?: any | undefined;
}

export interface IShowHTMLProps {
  html?: string | undefined;
}

export interface IToggleSwitchProps {
  className?: string;
  id?: string;
  label?: string;
  name?: string;
  onChange?: ChangeEventHandler<HTMLInputElement> | undefined;
  onClick?: (event?: React.MouseEvent<HTMLInputElement, MouseEvent>) => void;
  qa?: string;
  value?: string;
  checked?: boolean;
  defaultChecked?: boolean;
  parentCallback?: any;
}

export interface IProps extends Omit<React.InputHTMLAttributes<HTMLInputElement>, 'onChange'> {
  shared?: any | undefined;

  onChange(value: boolean): void;
}

export interface IErrorPageProps {
  text?: string | undefined;
  textarray?: any | undefined;
  headline?: string | undefined;
  showButton?: string | undefined;
  status?: number | undefined;
}

export interface IFormErrorProps {
  formErrors?: any | undefined;
}

export interface IInputProps extends JsxProps, ReactClassAttribute, ReactInputHTML {
  name?: string | undefined;
  id?: string | undefined;
  type?: string | undefined;
  className?: string | undefined;
  placeholder?: string | undefined;
  value?: string | number | undefined;
  defaultValue?: string | number | undefined;
  onChangeInput?: undefined;
  required?: boolean | undefined;
}

export interface IPageContentProps extends IContentProps {
  pagecontenttype?: number | undefined;
  data?: any | undefined;
}

export type IContentHeadlineProps = IDataProps;

export interface IContentProps extends IDataProps, IContentHeadlineProps {}

export interface IContentTextProps extends IDataProps {
  content?: string | any | undefined;
  className?: string | undefined;
}

export type IContentTextImageProps = IContentTextProps;

export interface IContentTextLeftProps extends IContentTextProps, IColBoxSize {}

export interface IContentChangerProps {
  data?: any | undefined;
  idx: number;
}

export interface IContentTextRightProps extends IContentTextProps, IColBoxSize {}

export interface IColBoxSize {
  boxleft?: number | undefined;
  boxright?: number | undefined;
}

export interface IContentArrayStringProps extends IDataProps {
  content?: string | any | undefined;
}

export type IContentGalleryProps = IDataProps;

export type IContentListProps = IDataProps;

export type IContentCalendarProps = IDataProps;

export type IContentTelephoneNumberProps = IDataProps;

export type IContentVehicleProps = IDataProps;
export type IContentVehicleSearchProps = IDataProps;

export type IVehicleSearchListProps = IDataProps;

export type IStationSearchListProps = IDataProps;
export type IContentStartpageTruckListProps = IDataProps;

export interface IVehicleOverviewListProps extends IDataProps {
  title?: string | undefined;
  vehicles?: any | undefined;
}

export type IContentVehicleDetailProps = IDataProps;

export type IContentVehicleDetailFloDithProps = IDataProps;

export type IContentEmergencyProps = IDataProps;

export type IContentEmergencyDetailProps = IDataProps;

export type INewsTruckCardProps = IDataProps;

export interface IEmergencyVehicleProps {
  img?: string | undefined;
  id?: string | undefined;
  images?: any | undefined;
  bos_kennung?: string | undefined;
  fahrzeug?: string | undefined;
}

export interface IFireRegisterDeclarationOfConsentProps extends IDataProps {
  href?: string | undefined;
  setParentValue: (arg: boolean) => void;
}

export interface IPrivacyNoticeProps extends IDataProps {
  href?: string | undefined;
  setParentValue: (arg: boolean) => void;
}

export type IContentEmergencyStatisticProps = IDataProps;

export type IContentEmergencyAreaProps = IDataProps;

export type IContentContactProps = IDataProps;

export type IContentEmergencyFireRegister = IDataProps;

export type IContentLinksProps = IDataProps;

export type IContentLinksLogoProps = IDataProps;

export type IContentImageProps = IDataProps;

export type IContentFacebookTimelineProps = IDataProps;

export type IContentInstagramTimelineProps = IDataProps;

export type IContentFormProps = IDataProps;

export type IContentDownloadProps = IDataProps;

export type IContentSitemapProps = IDataProps;

export type IContentManagementProps = IDataProps;

export interface IManagementFullProps {
  images?: any | undefined;
  data?: any | undefined;
  funktionIds?: any | undefined;
}

export interface IManagementFullDetailProps {
  id?: string | number | undefined;
  firstname?: string | undefined;
  surname?: string | undefined;
  function?: string | undefined;
  grade?: string | undefined;
  img?: string | undefined;
  images?: any | undefined;
  items?: any | object | undefined;
  data?: any | object | undefined;
}

export type IContentTimetableProps = IDataProps;

export type IContentErrorPageProps = IDataProps;

export type IContentPageNotFoundProps = IDataProps;

export type IContentSchedulerProps = IDataProps;

export type ISchedulerEntryProps = IDataProps;

export type IVehicleListProps = IDataProps;

export type IContentNewsOverviewProps = IDataProps;
export type IContentNewsFloDithProps = IDataProps;

export type IContentNewsDetailProps = IDataProps;

export interface IContentRowProps extends IDataProps {
  children?: any | undefined;
  className?: string | undefined;
}

export interface IContentStationProps {
  data?: any | undefined;
  params?: any | undefined;
  children?: any | undefined;
}

export interface IStationDetailsProps {
  data?: any | undefined;
}

export interface IStationDetailsInfoProps {
  data?: any | undefined;
}

export interface IEmergencyOverviewComponentProps {
  data?: any | undefined;
}

export interface IEmergencySetScenarioProps {
  data?: any | undefined;
}

export interface IModulEmergencyScenarioProps {
  data?: any | undefined;
  emergencydata?: any | undefined;
}

export interface ITacticalTimeProps {
  data?: any | undefined;
}

export interface IAppTacticalMonitorProps {
  data?: any | undefined;
}

export interface IAppOverviewProps {
  data?: any | undefined;
}

export interface IAppMoonProps {
  data?: any | undefined;
}

export interface IEmergencyAddEditComponentProps {
  beginn?: string | undefined;
  end?: string | undefined;
}

export interface IYearSelectorProps {
  years: any;
  active: number;
  onChange?: (event?: React.MouseEvent<HTMLSelectElement, MouseEvent>) => void;

  handleYear(value): void;
}

export interface IBuildEmergencyYearProps {
  data?: any | undefined;
  year?: number | string | undefined;
  statistic?: any | undefined;
}

export interface IBuildEmergencyMonthProps {
  data?: any | undefined;
  month?: string | number | undefined;
  year?: number | string | undefined;
}

export interface IBuildEmergencyMonthsProps {
  data?: any | undefined;
  year?: number | string | undefined;
}

export interface IBuildEmergencyEmptyProps {
  year?: string | number | undefined;
}

export interface IPageTitleProps {
  pageTitle?: string | undefined;
  title?: string | undefined;
}

export interface IPageHeadlineProps {
  label?: string | undefined;
}

export interface IButtonProps extends IDataProps, IRefProps {
  anchor?: boolean | undefined;
  label?: string | undefined;
  name?: string | undefined;

  type?: 'submit' | 'reset' | 'button' | undefined;
  color?: any | Colors;
  className?: string | undefined;
  id?: string | undefined;
  disabled?: boolean | undefined;
  onClick?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
}

export interface IButtonFAProps {
  color?: any | Colors;
  anchor?: string | undefined;
  className?: string | undefined;
  title?: string | undefined;
  FAclassName?: string | undefined;
  dataqa?: string | undefined;
  naviOpen?: boolean;
  disabled?: boolean | undefined;
  onClick?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
}

export interface ITextareaProps extends JsxProps, ReactTextAreaClassAttribute, ReactTextAreaHTML {
  name?: string | undefined;
  id?: string | undefined;
  className?: string | undefined;
  placeholder?: string | undefined;
  value?: string | number | undefined;
  defaultValue?: string | number | undefined;
  rows?: number | undefined;
  cols?: number | undefined;
}

export interface ITextareaEditorProps
  extends JsxProps,
    ReactTextAreaClassAttribute,
    ReactTextAreaHTML {
  name?: string | undefined;
  id?: string | undefined;
  className?: string | undefined;
  placeholder?: string | undefined;
  value?: string | undefined;
  defaultValue?: string | number | undefined;
  rows?: number | undefined;
  cols?: number | undefined;
}

export interface ISortTableProps
  extends ISortTableGridBodyTable,
    ISortTableHeadline,
    ISortTableGridBody {
  headline?: string | undefined;
  table_id?: string | undefined;
  sort?: any | undefined;
}

export interface ISortTableGridBody extends ISortTableHeadline, ISortTableGridBodySort {}

export interface ISortTableGridBodySort {
  sort?: any | undefined;
  search?: string | undefined;
  showPaginationList?: boolean | undefined;
  showSearchBox?: boolean | undefined;
}

export interface ISortTableHeadline {
  lable?: string | undefined;
  showTableButtons?: boolean | undefined;
}

export interface IGridSimpleProps {
  lable?: string | undefined;
  showTableButtons?: boolean | undefined;
  children?: any | undefined;
  className?: string | undefined;
}

export interface ISortTableGridBodyTable
  extends ISortTableGridBodyTableThead,
    ISortTableGridBodyTableTbody,
    ISortTableGridBodyTablePagination {
  id?: string | undefined;
  className?: string | undefined;
}

export interface ISortTableGridBodyTableThead {
  ths?: any | undefined;
  sort?: any | undefined;
}

export interface ISortTableGridBodyTableTbody {
  datas?: any | undefined;
}

export interface ISortTableGridBodyTablePagination {
  count?: number | undefined;
}

export interface IChangeLogAddEditProps {
  release?: string | undefined;
  date?: string | undefined;
}

export interface IToDoAddEditProps {
  title?: string | undefined;
  description?: string | undefined;
}

export interface IToDoProps {
  todo_area_id?: number | undefined;
  parent_id?: number | undefined;
  todotitle?: string | undefined;
  tododescription?: string | undefined;
  status?: any | undefined;
  status_id?: number | undefined;
  todo_area?: any | undefined;
  todo_status?: any | undefined;
  todo_type?: any | undefined;
}

export interface IToDoAreaProps {
  area?: string | undefined;
  id?: number | undefined;
}

export interface IShowLogsProps {
  id?: number | undefined;
}

export interface ISaveLineProps {
  SubmitForm?: any | undefined;
  backurl: string;
}

export interface IShowActiveProps {
  active?: number | string | boolean | undefined;
}

export interface ISyncActiveProps {}

export interface IShadowAreaProps {
  show_shadow?: boolean | undefined;
}

export interface IChangeLogProps extends IChangeLogDetailsProps {
  revision?: number | string | undefined;
  datum?: number | string | undefined;
}

export interface IChangeLogDetailsProps {
  revision?: number | string | undefined;
  datum?: number | string | undefined;
  task?: number | string | undefined;
  tasks?: number | any | string | undefined;
}

export interface INotificationMessageProps {
  headline?: string | undefined;
  description?: string | undefined;
  date?: string | number | undefined;
  type?: string | undefined;
}

export interface INotificationMessagesProps {
  headline?: string | undefined;
  color?: string | undefined;
  messages?: any | undefined;
  showControllButtons?: boolean | undefined;
}

export interface IModalProps extends IModalBodyProps, IModalFooterProps, IModalHeaderProps {
  show?: boolean | undefined;
  id?: string | undefined;
  showID?: boolean | undefined;
  onClickSave?: any | undefined;
  onClickAbort?: any | undefined;
}

export interface IModalBodyProps {
  children?: any | undefined;
}

export interface IModalHeaderProps {
  headline?: string | undefined;
  text?: string | undefined;
}

export interface IModalFooterProps {
  className?: string | undefined;
  onClickSave?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
  onClickAbort?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
}

export interface INotFoundProps {
  className?: string | undefined;
}

export interface IAlertBoxProps {
  className?: string | undefined;
  text?: string | undefined;
  textarray?: any | undefined;
  headline?: string | undefined;
  showButton?: boolean | string | undefined;
  errorObject?: object | any | undefined;
}

export type IAlertBoxInfoProps = IAlertBoxProps;
export type IAlertBoxErrorProps = IAlertBoxProps;
export type IAlertBoxSuccessProps = IAlertBoxProps;
export type IAlertBoxWarningProps = IAlertBoxProps;
export type IAlertBoxOfflineProps = IAlertBoxProps;
export type IAlertBoxBugProps = IAlertBoxProps;
export type IAlertBoxNotFoundProps = IAlertBoxProps;

export interface IAlertInfoLineProps {
  className?: string | undefined;
  text?: string | undefined;
  headline?: string | undefined;
  showButton?: boolean | undefined;
}

export interface IImageUploaderMultibleProps {
  images?: any | undefined;
  _id?: number | string | undefined;
  name?: string | undefined;
  token?: string | undefined;
}

export interface IImageUploaderSingleProps {
  image?: string | undefined;
  _id?: number | string | undefined;
  token?: string | undefined;
}

export interface IImageUploaderGalleryProps {
  image?: string | undefined;
  token?: string | undefined;
}

export interface IImageUploaderComponents
  extends IImageUploaderPreview,
    IImageUploaderMessages,
    IImageUploaderProgress {}

export interface IImageUplaoderImageList {
  imageInfos?: any | undefined;
}

export interface IImageUploaderProgress {
  progressInfos?: any | undefined;
  progress?: string | number | undefined;
  currentFile?: string | undefined;
}

export interface IImageUploaderPreview {
  image?: string | undefined;
  images?: any | undefined;
}

export interface IImageUploaderMessages {
  message?: string | undefined;
  messages?: any | undefined;
}

export interface IImageUploadExternalMultibleProps {
  _id?: number | string | undefined;
  token?: string | undefined;
  url?: string | undefined;
}

export interface IImageUploadFileUploadMultibleProps {
  _id?: number | string | undefined;
  token?: string | undefined;
  images?: any | undefined;
}

export interface IImageUploadExternalSingleProps {
  _id?: number | string | undefined;
  token?: string | undefined;
  url?: string | undefined;
}

export interface IImageUploadFileUploadSingleProps {
  _id?: number | string | undefined;
  token?: string | undefined;
  image?: any | undefined;
}

export interface SelectOption {
  display: string;
  value: string;
}

export interface SelectBoxProps {
  className?: string;
  onChange: (event?: React.MouseEvent<HTMLSelectElement, MouseEvent>) => void;
  onClick: (event?: React.MouseEvent<HTMLSelectElement, MouseEvent>) => void | undefined;
  label: string;
  options: SelectOption[];
  selected?: string | undefined;
}

export interface IWidgetLoaderProps {
  data?: any | undefined;
  widget?: any | undefined;
  pagedata?: any | undefined;
  warnings?: any | undefined;
}

export interface IWidgetProps {
  children?: any | undefined;
  pagedata?: any | undefined;
  widget?: any | undefined;
  warnings?: any | undefined;
}

export interface IWidgetRightProps extends IWidgetProps {
  data?: any | undefined;
}

export interface IWidgetLeftProps extends IWidgetProps {
  data?: any | undefined;
}

export interface IWidgetTopProps extends IWidgetProps {
  data?: any | undefined;
}

export interface IWidgetBottomProps extends IWidgetProps {
  data?: any | undefined;
}

export interface IWidgetCenterProps extends IWidgetProps {
  data?: any | undefined;
}

export interface ITermineOverviewComponentProps {}

export interface ITermineAddEditComponentProps {}

export interface IFacebookPostComponentProps {}

export interface IPlaceholderOverviewComponentProps {}

export interface IPlaceholderAddEditComponentProps {}

export interface ILinksOverviewComponentProps {}

export interface ILinksAddEditComponentProps {}

export type LayoutMainContentProps = ILayoutMainContentProps;
export type AsideContactProps = IAsideContactProps;
export type StartpageComponentProp = IStartpageComponentProp;
export type PageComponentProps = IPageComponentProps;
export type SectionHeroImageProps = ISectionHeroImageProps;
export type LayoutContainerProps = ILayoutContainerProps;
export type LogoProps = ILogoProps;
export type LogoWithNameProps = ILogoWithNameProps;
export type LogoWithoutTitleProps = ILogoWithoutTitleProps;
export type StartPageProps = IStartPageProps;
export type PageProps = IPageProps;
export type CountUpWithIconProps = ICountUpWithIconProps;
export type IAlertInfoLineInfoProps = IAlertInfoLineProps;
export type IAlertInfoLineErrorProps = IAlertInfoLineProps;
export type IAlertInfoLineSuccessProps = IAlertInfoLineProps;
export type IAlertInfoLineWarningProps = IAlertInfoLineProps;
export type JsxProps = JSX.IntrinsicAttributes;
export type ReactClassAttribute = React.ClassAttributes<HTMLInputElement>;
export type ReactInputHTML = React.InputHTMLAttributes<HTMLInputElement>;
export type ReactTextAreaClassAttribute = React.ClassAttributes<HTMLTextAreaElement>;
export type ReactTextAreaHTML = React.TextareaHTMLAttributes<HTMLTextAreaElement>;
export type AllFormProps = ISelectProps;
export type ReactSelectProps = IReactSelectProps;
export type AllSwitchProps = SwitchProps;
export type AllCheckboxProps = CheckboxProps;
export type HomepageProps = IHomepageProps;
export type ILocation = ILocationProps;
export type BlackdayProps = IBlackdayProps;
export type BlackdayMessageProps = IBlackdayMessageProps;
export type AllPictureProps = IAllPictureProps;
export type HeaderProps = IHeaderProps;
export type HeaderTitleContactProps = IHeaderTitleContactProps;
export type HeaderInstagramProps = IHeaderInstagramProps;
export type HeaderFacebookProps = IHeaderFacebookProps;
export type HeaderEmailProps = IHeaderEmailProps;
export type HeaderPhoneProps = IHeaderPhoneProps;
export type HeaderSocialMediaProps = IHeaderSocialMediaProps;
export type HeaderYoutubeProps = IHeaderYoutubeProps;
export type NewsProps = INewsProps;
export type SVGIconProps = ISVGIconProps;
export type AdminHeaderProps = IAdminHeaderProps;
export type AdminHeadlineProps = IAdminHeadlineProps;
export type FooterProps = IFooterProps;
export type FooterModulesProps = IFooterModulesProps;
export type FooterFlodithStatisticProps = IFooterFlodithStatisticProps;
export type BackToTopProps = IBackToTopProps;
export type SocialBarProps = ISocialBarProps;
export type PageContainerProps = IPageContainerProps;
export type PageAdminContainerProps = IPageAdminContainerProps;
export type PageAppContainerProps = IPageAppContainerProps;
export type PageAppWrapperProps = IPageAppWrapperProps;
export type TermineOverviewComponentProps = ITermineOverviewComponentProps;
export type TermineAddEditComponentProps = ITermineAddEditComponentProps;
export type FacebookPostComponentProps = IFacebookPostComponentProps;
export type PageWrapperProps = IPageWrapperProps;
export type PageAdminWrapperProps = IPageAdminWrapperProps;
export type FooterNavigationProps = IFooterNavigationProps;
export type HeaderNavigationProps = IHeaderNavigationProps;
export type HeaderNavLinkProps = IHeaderNavLinkProps;
export type HeaderNavDropdownProps = IHeaderNavDropdownProps;
export type HeaderNavTypeProps = IHeaderNavTypeProps;
export type HeaderMainNaviItemProps = IHeaderMainNaviItemProps;
export type HeaderMainNaviSubItemProps = IHeaderMainNaviSubItemProps;
export type BreadcrumbProps = IBreadcrumbProps;
export type AdminNavigationProps = IAdminNavigationProps;
export type GridColProps = IGridColProps;
export type GridRowProps = IGridRowProps;
export type ShowHTMLProps = IShowHTMLProps;
export type IconSetProps = IIconSetProps;
export type ToggleSwitchProps = IToggleSwitchProps;
export type AdminOverviewListProps = IAdminOverviewListProps;
export type AdminOverviewPageProps = IAdminOverviewPageProps;
export type ErrorPageProps = IErrorPageProps;
export type FormErrorProps = IFormErrorProps;
export type InputProps = IInputProps;
export type TextareaProps = ITextareaProps;
export type TextareaEditorProps = ITextareaEditorProps;
export type DashboardProps = IDashboardProps;
export type AdminStatisticProps = IAdminStatisticProps;
export type ErrorBoundrayProps = IErrorBoundrayProps;
export type ButtonFAProps = IButtonFAProps;
export type PageTitleProps = IPageTitleProps;
export type PageHeadlineProps = IPageHeadlineProps;
export type PageContentProps = IPageContentProps;
export type SortTableProps = ISortTableProps;
export type SortTableHeadline = ISortTableHeadline;
export type SortTableGridBody = ISortTableGridBody;
export type SortTableGridBodySort = ISortTableGridBodySort;
export type SortTableGridBodyTable = ISortTableGridBodyTable;
export type SortTableGridBodyTableThead = ISortTableGridBodyTableThead;
export type SortTableGridBodyTableTbody = ISortTableGridBodyTableTbody;
export type SortTableGridBodyTablePagination = ISortTableGridBodyTablePagination;
export type ToDoProps = IToDoProps;
export type ModalProps = IModalProps;
export type ModalHeaderProps = IModalHeaderProps;
export type ModalBodyProps = IModalBodyProps;
export type ModalFooterProps = IModalFooterProps;
export type H1Props = IH1Props;
export type H2Props = IH2Props;
export type H3Props = IH3Props;
export type H4Props = IH4Props;
export type H5Props = IH5Props;
export type H6Props = IH6Props;
export type H7Props = IH7Props;
export type PProps = IPProps;
export type LabelProps = ILabelProps;
export type LabelInputComponentProps = ILabelInputComponentProps;
export type LabelTextareaComponentProps = ILabelTextareaComponentProps;
export type FireRegisterDeclarationOfConsentProps = IFireRegisterDeclarationOfConsentProps;
export type PrivacyNoticeProps = IPrivacyNoticeProps;
export type AuthProps = IAuthProps;
export type LoginPageProps = ILoginPageProps;
export type RegisterProps = IRegisterProps;
export type VerifyEmailProps = IVerifyEmailProps;
export type PasswordResetProps = IPasswordResetProps;
export type ForgotPasswordProps = IForgotPasswordProps;
export type AlertBoxProps = IAlertBoxProps;
export type AlertBoxErrorProps = IAlertBoxErrorProps;
export type AlertBoxInfoProps = IAlertBoxInfoProps;
export type AlertBoxNotFoundProps = IAlertBoxNotFoundProps;
export type AlertBoxBugProps = IAlertBoxBugProps;
export type AlertBoxSuccessProps = IAlertBoxSuccessProps;
export type AlertBoxWarningProps = IAlertBoxWarningProps;
export type AlertBoxOfflineProps = IAlertBoxOfflineProps;
export type AlertInfoLineProps = IAlertInfoLineProps;
export type AlertInfoLineErrorProps = IAlertInfoLineErrorProps;
export type AlertInfoLineInfoProps = IAlertInfoLineInfoProps;
export type AlertInfoLineWarningProps = IAlertInfoLineWarningProps;
export type AlertInfoLineSuccessProps = IAlertInfoLineSuccessProps;
export type ButtonProps = IButtonProps;
export type ChangeLogProps = IChangeLogProps;
export type ChangeLogDetailsProps = IChangeLogDetailsProps;
export type NotificationMessageProps = INotificationMessageProps;
export type NotificationMessagesProps = INotificationMessagesProps;
export type ImageUploaderMultibleProps = IImageUploaderMultibleProps;
export type ImageUploaderSingleProps = IImageUploaderSingleProps;
export type ImageUploaderGalleryProps = IImageUploaderGalleryProps;
export type ImageUploadExternalMultibleProps = IImageUploadExternalMultibleProps;
export type ImageUploadExternalSingleProps = IImageUploadExternalSingleProps;
export type ImageUploadFileUploadMultibleProps = IImageUploadFileUploadMultibleProps;
export type ImageUploadFileUploadSingleProps = IImageUploadFileUploadSingleProps;
export type DIVProps = IDIVProps;
export type GridSimpleProps = IGridSimpleProps;
export type SpacerProps = ISpacerProps;
export type DivCheckboxProps = IDivCheckboxProps;
export type CheckboxProps = ICheckboxProps;
export type ToDoAddEditProps = IToDoAddEditProps;
export type NotFoundProps = INotFoundProps;
export type ChangeLogAddEditProps = IChangeLogAddEditProps;
export type SaveInfoErrorProps = ISaveInfoErrorProps;
export type ButtonAddLineProps = IButtonAddLineProps;
export type ButtonLineProps = IButtonLineProps;
export type ToDoAreaProps = IToDoAreaProps;
export type SaveLineProps = ISaveLineProps;
export type ShadowAreaProps = IShadowAreaProps;
export type ShowLogsProps = IShowLogsProps;
export type EinsaetzeProps = IEinsaetzeProps;
export type GridBoxProps = IGridBoxProps;
export type UnwetterInfoProps = IUnwetterInfoProps;
export type HappyHolidayProps = IHappyHolidayProps;
export type DanceBallProps = IDanceBallProps;
export type AnnualGeneralMeetingProps = IAnnualGeneralMeetingProps;
export type FlyerboxProps = IFlyerboxProps;
export type CriticalMessageProps = ICriticalMessageProps;
export type BloodDonationTermineProps = IBloodDonationTermineProps;
export type RowHeadlineProps = IRowHeadlineProps;
export type WidgetTermineProps = IWidgetTermineProps;
export type EinsatzMelderProps = IEinsatzMelderProps;
export type RescueEliminateBailSaveProps = IRescueEliminateBailSaveProps;
export type HydrantCheckInfoProps = IHydrantCheckInfoProps;
export type ReadyForUseProps = IReadyForUseProps;
export type DireStraitsProps = IDireStraitsProps;
export type PaulinchenTdbKProps = IPaulinchenTdbKProps;
export type FooterSocialMediaProps = IFooterSocialMediaProps;
export type FooterContactProps = IFooterContactProps;
export type FooterServiceProps = IFooterServiceProps;
export type FooterEmergencyProps = IFooterEmergencyProps;
export type NotrufProps = INotrufProps;
export type PhoneNumberProps = IPhoneNumberProps;
export type StatusInActiveProps = IStatusInActiveProps;
export type PhotoInformationProps = IPhotoInformationProps;
export type VehicleProcessProps = IVehicleProcessProps;
export type VehicleProcessOverviewProps = IVehicleProcessOverviewProps;
export type FooterContentProps = IFooterContentProps;
export type AnwesenheitOverviewProps = IAnwesenheitOverviewProps;
export type EinsatzDetailProps = IEinsatzDetailProps;
export type EinsatzOverviewProps = IEinsatzOverviewProps;
export type EinsatzgebietProps = IEinsatzgebietProps;
export type EmergencyAreaMapProps = IEmergencyAreaMapProps;
export type FireDepartmentStatisticProps = IFireDepartmentStatisticProps;
export type EmergencyMonthStatisticProps = IEmergencyMonthStatisticProps;
export type FireDepartmentFieldTypeProps = IFireDepartmentFieldTypeProps;
export type FireDepartmentFieldTypeDataProps = IFireDepartmentFieldTypeDataProps;
export type FireDepartmentFireRegisterProps = IFireDepartmentFireRegisterProps;
export type ContactFormInfoLineProps = IContactFormInfoLineProps;
export type ContentEmergencyFireRegisterProps = IContentEmergencyFireRegisterProps;
export type FiretruckOverviewProps = IFiretruckOverviewProps;
export type FiretruckOverviewComponentProps = IFiretruckOverviewComponentProps;
export type FireTruckImageProps = IFireTruckImageProps;
export type FiretruckDetailProps = IFiretruckDetailProps;
export type EmergencyMapProps = IEmergencyMapProps;
export type MapProps = IMapProps;
export type FiretruckOverviewDataProps = IFiretruckOverviewDataProps;
export type WidgetRightProps = IWidgetRightProps;
export type WidgetLeftProps = IWidgetLeftProps;
export type WidgetTopProps = IWidgetTopProps;
export type WidgetBottomProps = IWidgetBottomProps;
export type WidgetCenterProps = IWidgetCenterProps;
export type WidgetLoaderProps = IWidgetLoaderProps;
export type WeatherMessageProps = IWeatherMessageProps;
export type HeaderImageProps = IHeaderImageProps;
export type TermineProps = ITermineProps;
export type CoronaTermineProps = ICoronaTermineProps;
export type TermineVorbehaltProps = ITermineVorbehaltProps;
export type TermineEntryProps = ITermineEntryProps;
export type FireDepartmentUserProps = IFireDepartmentUserProps;
export type FireDepartmentUserPictureProps = IFireDepartmentUserPictureProps;
export type FireDepartmentUserAdressProps = IFireDepartmentUserAdressProps;
export type FireDepartmentManagementProps = IFireDepartmentManagementProps;
export type OrganisationStationProps = IOrganisationStationProps;
export type OrganisationHeadlineProps = IOrganisationHeadlineProps;
export type StationCardProps = IStationCardProps;
export type VehicleCardProps = IVehicleCardProps;
export type NewsBoxesProps = INewsBoxesProps;
export type NewsBoxProps = INewsBoxProps;
export type NewsBoxFloDithProps = INewsBoxFloDithProps;
export type MoreLinkProps = IMoreLinkProps;
export type ContentTextProps = IContentTextProps;
export type ContentTextImageProps = IContentTextImageProps;
export type ContentTextLeftProps = IContentTextLeftProps;
export type ContentChangerProps = IContentChangerProps;
export type ContentTextRightProps = IContentTextRightProps;
export type ContentArrayStringProps = IContentArrayStringProps;
export type ContentGalleryProps = IContentGalleryProps;
export type ContentHeadlineProps = IContentHeadlineProps;
export type ContentListProps = IContentListProps;
export type ContentCalendarProps = IContentCalendarProps;
export type ContentTelephoneNumberProps = IContentTelephoneNumberProps;
export type ContentVehicleProps = IContentVehicleProps;
export type ContentVehicleSearchProps = IContentVehicleSearchProps;
export type VehicleSearchListProps = IVehicleSearchListProps;
export type StationSearchListProps = IStationSearchListProps;
export type ContentStartpageTruckListProps = IContentStartpageTruckListProps;
export type VehicleOverviewListProps = IVehicleOverviewListProps;
export type VehicleListProps = IVehicleListProps;
export type ContentVehicleDetailProps = IContentVehicleDetailProps;
export type ContentVehicleDetailFloDithProps = IContentVehicleDetailFloDithProps;
export type ContentEmergencyProps = IContentEmergencyProps;
export type ContentEmergencyDetailProps = IContentEmergencyDetailProps;
export type EmergencyVehicleProps = IEmergencyVehicleProps;
export type ContentEmergencyStatisticProps = IContentEmergencyStatisticProps;
export type ContentEmergencyAreaProps = IContentEmergencyAreaProps;
export type ContentContactProps = IContentContactProps;
export type ContentEmergencyFireRegister = IContentEmergencyFireRegister;
export type ContentLinksProps = IContentLinksProps;
export type ContentLinksLogoProps = IContentLinksLogoProps;
export type ContentImageProps = IContentImageProps;
export type ContentFacebookTimelineProps = IContentFacebookTimelineProps;
export type ContentInstagramTimelineProps = IContentInstagramTimelineProps;
export type ContentFormProps = IContentFormProps;
export type ContentDownloadProps = IContentDownloadProps;
export type ContentSitemapProps = IContentSitemapProps;
export type ContentManagementProps = IContentManagementProps;
export type ManagementFullProps = IManagementFullProps;
export type ManagementFullDetailProps = IManagementFullDetailProps;
export type ContentTimetableProps = IContentTimetableProps;
export type ContentPageNotFoundProps = IContentPageNotFoundProps;
export type ContentErrorPageProps = IContentErrorPageProps;
export type ContentNewsOverviewProps = IContentNewsOverviewProps;
export type ContentNewsFloDithProps = IContentNewsFloDithProps;
export type ContentNewsDetailProps = IContentNewsDetailProps;
export type ContentRowProps = IContentRowProps;
export type ContentStationProps = IContentStationProps;
export type StationDetailsProps = IStationDetailsProps;
export type StationDetailsInfoProps = IStationDetailsInfoProps;
export type ContentSchedulerProps = IContentSchedulerProps;
export type SchedulerEntryProps = ISchedulerEntryProps;
export type EmergencyOverviewComponentProps = IEmergencyOverviewComponentProps;
export type EmergencySetScenarioProps = IEmergencySetScenarioProps;
export type ModulEmergencyScenarioProps = IModulEmergencyScenarioProps;
export type TacticalTimeProps = ITacticalTimeProps;
export type AppTacticalMonitorProps = IAppTacticalMonitorProps;
export type AppOverviewProps = IAppOverviewProps;
export type EmergencyAddEditComponentProps = IEmergencyAddEditComponentProps;
export type AppMoonProps = IAppMoonProps;
export type YearSelectorProps = IYearSelectorProps;
export type BuildEmergencyYearProps = IBuildEmergencyYearProps;
export type BuildEmergencyMonthProps = IBuildEmergencyMonthProps;
export type BuildEmergencyEmptyProps = IBuildEmergencyEmptyProps;
export type BuildEmergencyMonthsProps = IBuildEmergencyMonthsProps;
export type ShowActiveProps = IShowActiveProps;
export type EmergencyAlarmMailMessageProps = IEmergencyAlarmMailMessageProps;
export type EmergencyAlarmMailMessageRowEntryProps = IEmergencyAlarmMailMessageRowEntryProps;
export type EmergencyListProps = IEmergencyListProps;
export type EmergencyListEntryProps = IEmergencyListEntryProps;
export type PageAddEditHeadlineComponentProps = IPageAddEditHeadlineComponentProps;
export type PageAddEditComponentProps = IPageAddEditComponentProps;
export type PageOverviewComponentProps = IPageOverviewComponentProps;
export type PageOverviewRootProps = IPageOverviewRootProps;
export type PageContentTypeProps = IPageContentTypeProps;
export type PageOverviewSecondListProps = IPageOverviewSecondListProps;
export type PageOverviewRootListProps = IPageOverviewRootListProps;
export type PageOverviewThirtListProps = IPageOverviewThirtListProps;
export type PageOverviewFourthListProps = IPageOverviewFourthListProps;
export type EmergencyGetKoorginatesProps = IEmergencyGetKoorginatesProps;
export type SyncActiveProps = ISyncActiveProps;
export type PlaceholderOverviewComponentProps = IPlaceholderOverviewComponentProps;
export type PlaceholderAddEditComponentProps = IPlaceholderAddEditComponentProps;
export type LinksOverviewComponentProps = ILinksOverviewComponentProps;
export type LinksAddEditComponentProps = ILinksAddEditComponentProps;
export type StatisticPieProps = IStatisticPieProps;
export type StatisticHoriziontalBarProps = IStatisticHoriziontalBarProps;
export type StatisticLineProps = IStatisticLineProps;
export type StatisticVerticalBarProps = IStatisticVerticalBarProps;
export type FAProps = IFAProps;
export type StatisticBoxProps = IStatisticBoxProps;
export type StatisticBoxAreaProps = IStatisticBoxAreaProps;
export type LinkProps = ILinkProps;
export type CountdownProps = ICountdownProps;
export type NewsTruckCardProps = INewsTruckCardProps;
