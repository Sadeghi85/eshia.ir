CREATE TABLE [host443].[T_CMN_DFN] (
	[ID] [int] NOT NULL ,
	[PID] [int] NULL ,
	[Name] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Vlu] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_CMN_Person] (
	[Id] [int] IDENTITY (1, 1) NOT NULL ,
	[UserName] [varchar] (20) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[password] [varchar] (20) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[nicknamePersian] [varchar] (30) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[nicknameArabic] [varchar] (30) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[nicknameEnglish] [varchar] (30) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[DescriptionEnglish] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[DescriptionArabic] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[DescriptionPersian] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Active] [bit] NOT NULL ,
	[LogicalDelete] [bit] NOT NULL ,
	[link] [varchar] (100) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[FName] [varchar] (30) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[LName] [varchar] (40) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[BirthDay] [varchar] (8) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Province] [int] NOT NULL ,
	[City] [varchar] (30) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Grade] [int] NULL ,
	[Reshteh] [varchar] (20) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[EMail] [varchar] (40) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Sex] [bit] NOT NULL ,
	[GroupID] [int] NULL ,
	[UserType] [int] NOT NULL ,
	[treeOrder] [int] NOT NULL ,
	[Program] [tinyint] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_Chat_DFN] (
	[ID] [int] NOT NULL ,
	[PID] [int] NULL ,
	[Name] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Vlu] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_Chat_Person] (
	[Id] [int] NOT NULL ,
	[Messages] [text] COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY] 
GO

CREATE TABLE [host443].[T_Chat_RelationShip] (
	[Id] [int] NOT NULL ,
	[FriendId] [int] NOT NULL ,
	[Accept] [bit] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_DFN] (
	[ID] [int] NOT NULL ,
	[PID] [int] NULL ,
	[Name] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Vlu] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_Libraray] (
	[ID] [int] NOT NULL ,
	[PID] [int] NULL ,
	[Title] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[FromPage] [int] NOT NULL ,
	[ToPage] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourse] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TermID] [int] NOT NULL ,
	[CourseID] [int] NOT NULL ,
	[DayID] [int] NULL ,
	[TimeID] [int] NULL ,
	[InstructorID] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourseSession] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TermCourseID] [int] NOT NULL ,
	[SessionNo] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourseSessionContent] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TermCourseSessionID] [int] NOT NULL ,
	[Title] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[FileName] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY] 
GO

CREATE TABLE [host443].[T_EL_TermCourseSessionQuestion] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TermCourseSessionID] [int] NOT NULL ,
	[TypeID] [int] NOT NULL ,
	[CorrectAnswer] [tinyint] NOT NULL ,
	[Qustion] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[Answer1] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[Answer2] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[Answer3] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Answer4] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourseStudent] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[StudentID] [int] NOT NULL ,
	[TermCourseID] [int] NOT NULL ,
	[Grade] [numeric](5, 2) NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourseStudentAnswer] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[TermCourseStudentID] [int] NOT NULL ,
	[TermCourseSessionID] [int] NOT NULL ,
	[StartDate] [char] (10) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[StartTime] [char] (8) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[AnswerTime] [char] (8) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Grade] [numeric](5, 2) NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_EL_TermCourseStudentAnswerDetail] (
	[Id] [int] IDENTITY (1, 1) NOT NULL ,
	[TermCourseStudentAnswerID] [int] NOT NULL ,
	[QuestionID] [int] NOT NULL ,
	[AnswerNo] [int] NULL ,
	[Answer] [varchar] (255) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Grade] [numeric](5, 2) NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_QA_DFN] (
	[Id] [int] NOT NULL ,
	[PID] [int] NULL ,
	[Name] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[Vlu] [varchar] (50) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_QA_Questions] (
	[ID] [int] IDENTITY (1, 1) NOT NULL ,
	[Question] [text] COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[Answer] [text] COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY] 
GO

CREATE TABLE [host443].[T_QA_QuestionsSubject] (
	[QuestionID] [int] NOT NULL ,
	[SubjectID] [int] NOT NULL 
) ON [PRIMARY]
GO

CREATE TABLE [host443].[T_Reports_Logs] (
	[UserID] [int] NOT NULL ,
	[DateIn] [varchar] (10) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[TimeIn] [varchar] (8) COLLATE SQL_Latin1_General_CP1256_CI_AS NOT NULL ,
	[IP] [varchar] (15) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[DateOut] [varchar] (10) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL ,
	[TimeOut] [varchar] (8) COLLATE SQL_Latin1_General_CP1256_CI_AS NULL 
) ON [PRIMARY]
GO

ALTER TABLE [host443].[T_CMN_DFN] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_CMN_DFN] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_CMN_Person] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_CMN_Person] PRIMARY KEY  CLUSTERED 
	(
		[Id]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_Chat_DFN] WITH NOCHECK ADD 
	CONSTRAINT [PK_Groups] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_Chat_Person] WITH NOCHECK ADD 
	CONSTRAINT [PK_Offlines] PRIMARY KEY  CLUSTERED 
	(
		[Id]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_Chat_RelationShip] WITH NOCHECK ADD 
	CONSTRAINT [PK_RelationShip] PRIMARY KEY  CLUSTERED 
	(
		[Id],
		[FriendId]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_DFN] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_DFN] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_Libraray] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_Libraray] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourse] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourse] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseSession] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseSession] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseSessionContent] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseSessionContent] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseSessionQuestion] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseQuestion] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudent] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseStudent] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudentAnswer] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseStudentAnswer_1] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudentAnswerDetail] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_EL_TermCourseStudentAnswerDetail] PRIMARY KEY  CLUSTERED 
	(
		[Id]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_QA_DFN] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_QA_DFN] PRIMARY KEY  CLUSTERED 
	(
		[Id]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_QA_Questions] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_QA_Questions] PRIMARY KEY  CLUSTERED 
	(
		[ID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_QA_QuestionsSubject] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_QA_QuestionsSubject] PRIMARY KEY  CLUSTERED 
	(
		[QuestionID],
		[SubjectID]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_Reports_Logs] WITH NOCHECK ADD 
	CONSTRAINT [PK_T_Reports_Logs] PRIMARY KEY  CLUSTERED 
	(
		[UserID],
		[DateIn],
		[TimeIn]
	)  ON [PRIMARY] 
GO

ALTER TABLE [host443].[T_CMN_Person] WITH NOCHECK ADD 
	CONSTRAINT [DF_T_CMN_Person_Active] DEFAULT (1) FOR [Active],
	CONSTRAINT [DF_T_CMN_Person_LogicalDelete] DEFAULT (0) FOR [LogicalDelete],
	CONSTRAINT [DF_T_CMN_Person_UserType] DEFAULT (100601) FOR [UserType],
	CONSTRAINT [DF_T_CMN_Person_treeOrder] DEFAULT (100) FOR [treeOrder],
	CONSTRAINT [DF_T_CMN_Person_Program] DEFAULT (0) FOR [Program]
GO

 CREATE  UNIQUE  INDEX [IX_T_EL_TermCourseStudent] ON [host443].[T_EL_TermCourseStudent]([StudentID], [TermCourseID]) ON [PRIMARY]
GO

 CREATE  UNIQUE  INDEX [IX_T_EL_TermCourseStudentAnswer] ON [host443].[T_EL_TermCourseStudentAnswer]([TermCourseStudentID], [TermCourseSessionID]) ON [PRIMARY]
GO

ALTER TABLE [host443].[T_CMN_DFN] ADD 
	CONSTRAINT [FK_T_CMN_DFN_T_CMN_DFN] FOREIGN KEY 
	(
		[PID]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_CMN_Person] ADD 
	CONSTRAINT [FK_T_CMN_Person_T_CMN_DFN] FOREIGN KEY 
	(
		[Province]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_CMN_Person_T_CMN_DFN1] FOREIGN KEY 
	(
		[Grade]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_CMN_Person_T_CMN_DFN2] FOREIGN KEY 
	(
		[GroupID]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_CMN_Person_T_CMN_DFN3] FOREIGN KEY 
	(
		[UserType]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_Chat_DFN] ADD 
	CONSTRAINT [FK_Groups_Groups] FOREIGN KEY 
	(
		[PID]
	) REFERENCES [host443].[T_Chat_DFN] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_Chat_Person] ADD 
	CONSTRAINT [FK_Offlines_T_CMN_Person] FOREIGN KEY 
	(
		[Id]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_Chat_RelationShip] ADD 
	CONSTRAINT [FK_RelationShip_T_CMN_Person] FOREIGN KEY 
	(
		[Id]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_RelationShip_T_CMN_Person1] FOREIGN KEY 
	(
		[FriendId]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_DFN] ADD 
	CONSTRAINT [FK_T_EL_DFN_T_EL_DFN] FOREIGN KEY 
	(
		[PID]
	) REFERENCES [host443].[T_EL_DFN] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_Libraray] ADD 
	CONSTRAINT [FK_T_EL_Libraray_T_EL_Libraray] FOREIGN KEY 
	(
		[PID]
	) REFERENCES [host443].[T_EL_Libraray] (
		[ID]
	)
GO

ALTER TABLE [host443].[T_EL_TermCourse] ADD 
	CONSTRAINT [FK_T_EL_TermCourse_T_CMN_DFN3] FOREIGN KEY 
	(
		[DayID]
	) REFERENCES [host443].[T_CMN_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourse_T_CMN_Person] FOREIGN KEY 
	(
		[InstructorID]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourse_T_EL_DFN] FOREIGN KEY 
	(
		[TimeID]
	) REFERENCES [host443].[T_EL_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourse_T_EL_DFN1] FOREIGN KEY 
	(
		[CourseID]
	) REFERENCES [host443].[T_EL_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourse_T_EL_DFN2] FOREIGN KEY 
	(
		[TermID]
	) REFERENCES [host443].[T_EL_DFN] (
		[ID]
	) ON UPDATE CASCADE  NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseSession] ADD 
	CONSTRAINT [FK_T_EL_TermCourseSession_T_EL_TermCourse] FOREIGN KEY 
	(
		[TermCourseID]
	) REFERENCES [host443].[T_EL_TermCourse] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseSessionContent] ADD 
	CONSTRAINT [FK_T_EL_TermCourseSessionContent_T_EL_TermCourseSession] FOREIGN KEY 
	(
		[TermCourseSessionID]
	) REFERENCES [host443].[T_EL_TermCourseSession] (
		[ID]
	) ON DELETE CASCADE  ON UPDATE CASCADE  NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseSessionQuestion] ADD 
	CONSTRAINT [FK_T_EL_CourseTermQuestions_T_EL_DFN] FOREIGN KEY 
	(
		[TypeID]
	) REFERENCES [host443].[T_EL_DFN] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourseSessionQuestion_T_EL_TermCourseSession] FOREIGN KEY 
	(
		[TermCourseSessionID]
	) REFERENCES [host443].[T_EL_TermCourseSession] (
		[ID]
	) ON DELETE CASCADE  ON UPDATE CASCADE  NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudent] ADD 
	CONSTRAINT [FK_T_EL_TermCourseStudent_T_CMN_Person] FOREIGN KEY 
	(
		[StudentID]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourseStudent_T_EL_TermCourse] FOREIGN KEY 
	(
		[TermCourseID]
	) REFERENCES [host443].[T_EL_TermCourse] (
		[ID]
	) ON UPDATE CASCADE  NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudentAnswer] ADD 
	CONSTRAINT [FK_T_EL_TermCourseStudentAnswer_T_EL_TermCourseSession] FOREIGN KEY 
	(
		[TermCourseSessionID]
	) REFERENCES [host443].[T_EL_TermCourseSession] (
		[ID]
	) ON DELETE CASCADE  ON UPDATE CASCADE  NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourseStudentAnswer_T_EL_TermCourseStudent1] FOREIGN KEY 
	(
		[TermCourseStudentID]
	) REFERENCES [host443].[T_EL_TermCourseStudent] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_EL_TermCourseStudentAnswerDetail] ADD 
	CONSTRAINT [FK_T_EL_TermCourseStudentAnswer_T_EL_TermCourseSessionQuestion] FOREIGN KEY 
	(
		[QuestionID]
	) REFERENCES [host443].[T_EL_TermCourseSessionQuestion] (
		[ID]
	) NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_EL_TermCourseStudentAnswerDetail_T_EL_TermCourseStudentAnswer] FOREIGN KEY 
	(
		[TermCourseStudentAnswerID]
	) REFERENCES [host443].[T_EL_TermCourseStudentAnswer] (
		[ID]
	) ON DELETE CASCADE  ON UPDATE CASCADE  NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_QA_DFN] ADD 
	CONSTRAINT [FK_T_QA_DFN_T_QA_DFN] FOREIGN KEY 
	(
		[PID]
	) REFERENCES [host443].[T_QA_DFN] (
		[Id]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_QA_QuestionsSubject] ADD 
	CONSTRAINT [FK_T_QA_QuestionsSubject_T_QA_DFN] FOREIGN KEY 
	(
		[SubjectID]
	) REFERENCES [host443].[T_QA_DFN] (
		[Id]
	) ON UPDATE CASCADE  NOT FOR REPLICATION ,
	CONSTRAINT [FK_T_QA_QuestionsSubject_T_QA_Questions] FOREIGN KEY 
	(
		[QuestionID]
	) REFERENCES [host443].[T_QA_Questions] (
		[ID]
	) NOT FOR REPLICATION 
GO

ALTER TABLE [host443].[T_Reports_Logs] ADD 
	CONSTRAINT [FK_T_Reports_Logs_T_CMN_Person] FOREIGN KEY 
	(
		[UserID]
	) REFERENCES [host443].[T_CMN_Person] (
		[Id]
	) NOT FOR REPLICATION 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE FUNCTION fn_CMN_Dfn_GetID( @PID as int ,@Names as varchar(250))
RETURNS int AS  
BEGIN 
	declare @s as varchar(50),
		@I as int,
		@PID1 as int
	set @PID = ltrim( rtrim(@PID))
	while @Names<>'' 
	begin
		set @I=CHARINDEX('\', @Names)
		if @I=0 
		begin
			set @S= @Names
			set @Names=''
		end
		else
		begin
			set @s= left( @Names , @I-1)
			set @Names= right(@Names,len(@Names)-@I)
		end
		set @PID1 = @PID
		set @PID = null
		select @PID= ID from T_CMN_Dfn(nolock) where (PID =@PID1 or (@PID1 is null and PID is null) ) and Name=@S
	end
	return @PID 
END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE FUNCTION fn_CMN_Dfn_GetParents( @ID as int)
RETURNS varchar(4000) AS  
begin
Declare @Result as varchar(4000),
	@Name as varchar(255)

	Set @Result=''
	while  @ID is not null
	begin
		Select @Name = Name , @ID=PID from T_CMN_DFN(Nolock) where ID=@ID
		if @Result <>'' Set @Result = '\'+@Result
		Set @Result = @Name + @Result
	end
	
	return @Result 
END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO

CREATE FUNCTION fn_CMN_Dfn_GetVlu( @ID as int)
RETURNS varchar(50) AS  
BEGIN 
	declare @Vlu as varchar(50)
	select @Vlu= Vlu from T_CMN_Dfn(nolock) 	where ID =@ID 
	return @Vlu
END

GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE FUNCTION fn_EL_Dfn_GetID( @PID as int ,@Names as varchar(250))
RETURNS int AS  
BEGIN 
	declare @s as varchar(50),
		@I as int,
		@PID1 as int
	set @PID = ltrim( rtrim(@PID))
	while @Names<>'' 
	begin
		set @I=CHARINDEX('\', @Names)
		if @I=0 
		begin
			set @S= @Names
			set @Names=''
		end
		else
		begin
			set @s= left( @Names , @I-1)
			set @Names= right(@Names,len(@Names)-@I)
		end
		set @PID1 = @PID
		set @PID = null
		select @PID= ID from T_EL_Dfn(nolock) where (PID =@PID1 or (@PID1 is null and PID is null) ) and Name=@S
	end
	return @PID 
END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

SET QUOTED_IDENTIFIER ON 
GO
SET ANSI_NULLS ON 
GO


CREATE FUNCTION fn_EL_Dfn_GetVlu( @ID as int)
RETURNS varchar(50) AS  
BEGIN 
	declare @Vlu as varchar(50)
	select @Vlu= Vlu from T_EL_Dfn(nolock) 	where ID =@ID 
	return @Vlu
END


GO
SET QUOTED_IDENTIFIER OFF 
GO
SET ANSI_NULLS ON 
GO

